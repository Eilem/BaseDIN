<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ErrorController extends Controller
{


    public function index()
    {

        $this->meta('Página não localizada');
        $menuSelected = "";

        $data = compact(
                  'menuSelected'
        );

        return view('errors.404')->with($data);
    }

}
