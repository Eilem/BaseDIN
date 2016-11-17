<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use App\Repositories\SidebarRepository;
use App\Repositories\Traits\InfoPageTrait;

class PageController extends Controller
{
    
    use InfoPageTrait;

    protected $repository;
    protected $sidebarRepository;

    public function __construct(PageRepository $repository, SidebarRepository $sidebarRepository)
    {
        $this->repository = $repository;
        $this->sidebarRepository = $sidebarRepository;
    }

    public function getByUri($slug)
    {
        $page = $this->repository->getByUri($slug);
        if(!$page)
        {
            return redirect(route('404'));
        }
        
        $titlePage = $page->title;
        $this->checkAndSetInfoPage('/pagina/'.$slug.'/'); //setando metatags

        $menuSelected = $this->getMenuSelected();
        $breadcrumb = $this->getBreadcrumb();
        $colSidebar = $this->sidebarRepository->getColByPageLink( $page->uri );

        $data = compact(
              'page',
              'menuSelected',
              'colSidebar',
              'breadcrumb',
              'titlePage'
        );

        return view('page')->with($data);
    }

}
