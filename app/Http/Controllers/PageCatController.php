<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\PageCatRepository;
use App\Repositories\SidebarRepository;
use App\Repositories\Traits\InfoPageTrait;

class PageCatController extends Controller
{
    use InfoPageTrait;

    protected $repository;
    protected $sidebarRepository;

    public function __construct(PageCatRepository $repository, SidebarRepository $sidebarRepository)
    {
        $this->repository = $repository;
        $this->sidebarRepository = $sidebarRepository;
    }


    /**
     * Get conteúdo do menu por uri
     * @param type $slug
     * @return type
     */
    public function getByUri($slug)
    {
        $page = $this->repository->getByUri($slug);

        if(!$page)
        {
            return redirect(route('404'));
        }
        
        $this->checkAndSetInfoPage('/menu/'.$slug.'/'); //setando metatags

        $menuSelected = $this->getMenuSelected();
        $breadcrumb = $this->getBreadcrumb();
       
        $titlePage =  $page->title;
        $colSidebar = $this->sidebarRepository->getColByPageLink( $page->uri );

        $data = compact(
                    'page',
                    'menuSelected',
                    'breadcrumb',
                    'colSidebar',
                    'titlePage'
        );

        return view('page')->with($data);
    }

}
