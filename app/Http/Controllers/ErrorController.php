<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Traits\InfoPageTrait;

class ErrorController extends Controller
{
    use InfoPageTrait;

    public function index()
    {
        $this->titlePage = "Página não localizada";
        $page = $this->checkAndSetInfoPage("/404");

        if(!$page)
        {
            $this->setMetatag( $this->titlePage);
        }
      
        return view('errors.404');
    }

}
