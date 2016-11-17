<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;

class PageCatRepository extends BaseRepository
{
    protected $model = \App\Models\PageCat::class;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtém uma coleção com objetos Menu de acordo com os parâmetros recebidos
     *
     * @param String $type       Tipo de menu
     * @param Int $limit         Quantidade de itens de menu retornados
     * @param Array $arrayField  Campos que devem ser retornados na consulta
     * @param Array $with        Relacionamento(s)
     *
     * @return Collection PageCat
     */
    public function getColByType($type, $limit = null, $arrayField = null,  $with = array() )
    {
        if($with)
        {
            $this->with = $with;
            $this->setWith();
        }

        if($arrayField)
        {
            $this->arrayField  = $arrayField;
        }

        if($limit)
        {
            $this->limit  = $limit;
        }

        $this->isActive();
        $this->isDel();
        $this->query->where('type', $type);

        $this->query->orderBy('sequence');

        $colMenu = $this->doQuery();

        return $colMenu;
    }


    /**
     * Obtém um objeto menu de acordo o slug e parâmetos recebidos.
     *
     * @param String $slug            Uri parcial do Menu
     * @param String $type            Tipo do menu
     * @param Array  $relationships   Array contendo os Relacionamento(s)
     *
     * @return \App\Models\PageCat Entidade Menu
     */
    public function getByUri($slug , $type = null , $relationships = null )
    {
        if($type)
        {
            $this->query->where('type', $type);
        }

        if($relationships)
        {
            $this->with = $relationships;
            $this->setWith();
        }

        $uri = '/menu/'.$slug.'/';
  
        $this->isActive();
        $this->isDel();
        $this->query->where('uri',$uri);

        $this->arrayField = [
            'id_page_cat',
            'title',
            'content',
            'sequence',
            'cover',
            'description',
            'uri',
            'url'
        ];

        $pageCat = $this->getOne();
        
        if(!$pageCat)
        {
            Log::error("Página de menu com slug: $slug, não localizado.",['PageCatRepository', 'getByUri'] );
            throw new NotFoundException("Página de menu não localizado.");
        }

        return $pageCat;
    }

    /**
     * Obtém um objeto menu a partir da url recebida.
     *
     * @param String $url  Url do Menu
     *
     * @return \App\Models\PageCat Entidade Menu
     */
    public function getByUrl($url)
    {
        $this->isActive();
        $this->isDel();
        $this->query->where('url',$url);

        $pageCat = $this->getOne();

        return $pageCat;
    }
    
    /**
     * Obtem as Páginas de Menu ativas para o Sitemap
     * @return Collection
     */
    public function getToSitemap()
    {
        $this->arrayField = [
            'uri'
        ];
        
        return $this->getAllActive();
    }
    
    /**
     * Obtém todas as páginas menu , ordenadas por sequencia
     * @return Collection
     */
    public  function getAllActive()
    {
        $this->isActive();
        $this->isDel();

        $this->query->orderBy(\DB::raw('sequence = 0 , sequence, title'), 'asc');

        $col =  $this->doQuery();
        return $col;
    }

}
