<?php

namespace App\Http\Views\Composers;

use Illuminate\View\View;
use App\Repositories\PageCatRepository;
use App\Models\PageCat;

class MenuComposer
{
    protected $menuMainRepository;

    /**
     * Create a new profile composer.
     * @param PageCatRepository $menuMainRepository
     */
    public function __construct(PageCatRepository $menuMainRepository)
    {
        $this->menuMainRepository = $menuMainRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $arrayField = [
            'id_page_cat',
            'title',
            'target',
            'uri',
            'url',
        ];
        $colMenuMain   = $this->menuMainRepository->getColByType(PageCat::$typeMain, 8, $arrayField, 'colPage' );
        $data = compact( 'colMenuMain');

        $view->with($data);
    }
}
