<?php

namespace App\Repositories;


use Carbon\Carbon;
use App\Repositories\PageCatRepository;
use App\Repositories\PageRepository;
use URL;

class SitemapRepository 
{
  
    protected $sitemap;
    
    protected $currentDate;
    
    protected $pageCatRep;
    protected $pageRep;
    
    
    public function __construct(PageCatRepository $pageCatRep, PageRepository $pageRep ) 
    {
        $this->pageCatRep      = $pageCatRep;
        $this->pageRep         = $pageRep;
        
        $this->sitemap         = \App::make("sitemap");
        $this->currentDate     = Carbon::now();
    }

    /**
     * Obtém o sitemap 
     * @return Xml Rotas sitemap
     */
    public function getSitemap(  )
    {

        /*
         * Home
         */
        $this->sitemap->add( route('home.index'),$this->currentDate , '1.0', 'daily' );
        
        
        /**
         * Páginas de Menu
         */
        $this->getPageCat();
             
        /**
         * Paginas
         */
        $this->getPage();
        
        /*
         * Página de contato
         */
        $this->sitemap->add( route('contact.index'),$this->currentDate , '1.0', 'daily' );
        
        
        

        return $this->sitemap->render('xml');
    }
    
    /**
    * Sitemap das páginas de Menus
    */   
    private function getPageCat()
    {
        $colMenu = $this->pageCatRep->getToSitemap();

        foreach($colMenu as $currentMenu)
        {    
            $this->sitemap->add( URL::to($currentMenu->uri), $this->currentDate,  '1.0', 'daily' );
        }   
    }
    
    /**
    * Sitemap das páginas 
    */   
    private function getPage()
    {
        $colPage = $this->pageRep->getToSitemap();

        foreach($colPage as $current)
        {    
            $this->sitemap->add( URL::to($current->uri), $this->currentDate,  '1.0', 'daily' );
        }   
    }
    

}
