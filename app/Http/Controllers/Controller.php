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
     * Seta metag
     * @param string $title  titulo da página
     * @param string $description descrição da página
     * @param string $image imagem da página
     * @param bollean $home
     */
    protected function meta($title, $description = null, $image = null, $home = false)
    {
        $settingsRepository = new SettingsRepository();
        $settings = $settingsRepository->get();

        Meta::meta('robots', 'index,follow');

        if ( $home )
        {
            Meta::meta( 'title', $settings->home_title );

        } else {

            Meta::meta( 'title', $title . ' - ' . $settings->title );
        }

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
