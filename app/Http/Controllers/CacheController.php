<?php

namespace App\Http\Controllers;

use Cache;

class CacheController extends Controller
{

    public function clearAll()
    {
        Cache::flush();
        return response()->json("Caches removidos");
    }

}
