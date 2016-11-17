<?php

namespace App\Repositories\Traits;

use Meta;
use App\Repositories\SettingsRepository;

trait MetatagTrait
{

    /**
     * Obtém as metatags da Home, definidas em settings
     */
    protected function getMetatagHome()
    {
        $settingsRepository = new SettingsRepository();
        $settings = $settingsRepository->getInfoHome();
        
        Meta::meta('robots', 'index,follow');
        Meta::meta( 'title', $settings->home_title );
        Meta::meta( 'description', $settings->home_description);
        Meta::meta( 'image', asset( getenv( 'DEFAULT_IMAGE') ) );
        
    }

    /**
     * Seta metatags da página
     *
     * @param String $title         Título da página
     * @param String $description   Descrição da página
     * @param String $image         Imagem da página
     */
    protected function setMetatag($title, $description = null, $image = null)
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
