<?php

namespace App\Repositories\Traits;

use App\Repositories\PageRepository;
use App\Repositories\PageCatRepository;
use App\Models\Page;
use App\Repositories\Traits\MetatagTrait;

trait InfoPageTrait
{
    use MetatagTrait;

    /**
     * Item do menu selecioando, normalmente será utilizado para mostrar o item
     * no menu principal que está ativo
     *
     * @var String
     */
    private $menuSelected;

    /**
     * Titulo da página exibido quando o título é dinâmico
     *
     * @var String
     */
    protected $titlePage;

    /**
     * Breadcumb das páginas,setado o valor inicial home.
     *
     * @var Array
     */
    private $breadcrumb = array(
        array("title" => "Home", "link" => "/")
    );


    /**
     * Adiciona um item ao array de breadcrumb de acordo com os parâmetros recebidos
     *
     * @param [string] $title Título do breadcrumb
     * @param [string] $link  Link do breadcrumb
     */
    public function setBreadcrumb($title, $link)
    {
        $this->breadcrumb[] = array('title' => $title, 'link' => $link);
    }

    /**
     * Retorna o breadcrumb definido
     *
     * @return [Array] breadcrumb
     */
    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    /**
     * Seta qual o menu selecionado
     *
     * @param String $uriMenu  URI do menu
     */
    public function setMenuSelected($uriMenu)
    {
        $this->menuSelected = $uriMenu;
    }

    /**
     * Retorna o menuSelected que foi definido na varíavel $menuSelected
     *
     * @return String Uri do menu selecionado
     */
    public function getMenuSelected()
    {
        return $this->menuSelected;
    }

    /**
     * Recebe a rota e verifica se está é a url de alguma página institucional (menu ou página)
     *
     * @param String $route
     *
     * @return type
     */
    protected function checkAndSetInfoPage( $route )
    {
        $page = false;

        $pageCatRepository = new PageCatRepository();
        $page = $pageCatRepository->getByUrl( $route );

        if($page)
        {
            $this->setDataMenu($page);
            return $page;

        }else {

            $pageRepository = new PageRepository();
            $page = $pageRepository->getByUrl($route);

            if($page)
            {
                $this->setDataPage($page);
                return $page;
            }
        }
        
        return ($page);
    }

    /**
     * Seta os dados da página do tipo PageCat
     * @return [type] [description]
     */
    protected function setDataMenu( $menuPage )
    {
        $this->titlePage = $menuPage->title;
        $this->setMenuSelected($menuPage->uri);

        $this->setMetatag(
            $menuPage->title,
            $menuPage->description,
            $menuPage->getPresenter()->coverToMetatag
        );

        //seta breadcrumb do menu ( lembrando que a home já foi setada inicialmente na variável ($this->breadcrumb)
        $this->setBreadcrumb($menuPage->title, $menuPage->getPresenter()->link );
    }


    /**
     * Seta os dados da página do tipo Page
     * @return [type] [description]
     */
    protected function setDataPage( $page )
    {
        $this->titlePage = $page->title;
        $this->menuSelected = $page->menu->uri;

        $this->setMetatag(
            $page->title,
            $page->description,
            $page->getPresenter()->coverToMetatag
        );

        $this->setBreadcrumbToInstitutionalPage($page);
    }

    /**
     * Seta o breadcrumb para as páginas institucionais (internas)
     * Obs.: Pára página principal (menu) utilizar o método setBreadcrumb
     *
     * @param [\App\Models\Page] $page página da qual será gerado o breadcrumb
     */
    public function setBreadcrumbToInstitutionalPage( Page $page  )
    {
        //seta breadcrumb do menu ( lembrando que a home já foi setada inicialmente na variável ($this->breadcrumb)
        $this->setBreadcrumb( $page->menu->title, $page->menu->getPresenter()->link );
        $this->setBreadcrumb( $page->title, $page->getPresenter()->link );
        
    }


}
