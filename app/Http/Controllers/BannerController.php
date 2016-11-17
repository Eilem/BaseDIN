<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\BannerRepository;
use App\Models\Banner;

class BannerController extends Controller
{
    protected $bannerRepository;

    public function __construct(BannerRepository $repository)
    {
        $this->bannerRepository = $repository;
    }

    
    /**
     * Obtém a view parcial contendo os banners da Home
     * @return View
     */
    public function getHome()
    {
        $colBanner  = $this->bannerRepository->getColByPosition( Banner::$positionHome, 3 );   

        return view("partials.home.banner" ,['colBanner' => $colBanner ] );
    }
}
