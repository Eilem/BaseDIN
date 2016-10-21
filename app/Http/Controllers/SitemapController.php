<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\SitemapRepository;

class SitemapController extends Controller
{
    protected $repository;

    /**
     * Método constutor
     */
    public function __construct( SitemapRepository $repository)
    {
        $this->repository = $repository;

    }


    public function index()
    {
        return $this->repository->getSitemap() ;

    }


}
