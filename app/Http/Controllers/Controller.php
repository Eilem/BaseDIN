<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Meta;

use App\Repositories\SettingsRepository;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Seta as metatag da Home, definidas em settings
     */
    protected function homeMeta()
    {
        $settingsRepository = new SettingsRepository();
        $settings = $settingsRepository->get();

        Meta::meta('robots', 'index,follow');
        Meta::meta( 'title', $settings->home_title );
        Meta::meta('description', $settings->home_description);
        Meta::meta( 'image', asset( getenv( 'DEFAULT_IMAGE') ) );
        
    }

    /**
     * Seta metatag
     * @param String $title         Título da página
     * @param String $description   Descrição da página
     * @param String $image         Imagem da página
     */
    protected function meta($title, $description = null, $image = null)
    {
        $settingsRepository = new SettingsRepository();
        $settings = $settingsRepository->get();

        Meta::meta('robots', 'index,follow');
        Meta::meta( 'title', $title . ' - ' . $settings->title );

        if( $description )
        {
            Meta::meta('description', $description);

        } else {

            Meta::meta('description', $settings->description);
        }

        if ( $image )
        {
            Meta::meta( 'image', $image );

        } else {
            // exibe a imagem default na metatag
            Meta::meta( 'image', asset( getenv( 'DEFAULT_IMAGE') ) );
        }
    }

}
