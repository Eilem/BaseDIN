<?php

namespace App\Repositories;

use Carbon\Carbon;
use URL;

class SitemapRepository
{

    protected $sitemap;
    protected $currentDate;

    public function __construct()
    {
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
         * Ex com url erro
         */
        $this->sitemap->add( route('404'),$this->currentDate , '1.0', 'daily' );
       
        /**
         * TO Dinamic use:
         */
        //$this->sitemap->add( URL::to( 'uri'), $this->currentDate,  '1.0', 'daily' );
     
         return $this->sitemap->render('xml');

    }

}
