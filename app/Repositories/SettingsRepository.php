<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class SettingsRepository extends BaseRepository
{
    protected $model = \App\Models\Settings::class;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtém a Configuração da aplicação definida no painel administrativo
     * @return Settings
     */
    public function get()
    {
        return $this->findById(1);

    }
    
    /**
     * Obtém settings contendo as informações das metatags da home 
     * 
     * @return Settings
     */
    public function getInfoHome()
    {
        $this->arrayField = [
            'home_title',
            'home_description'
        ];
        
        return $this->findById(1);
    }

    
    /**
     * Obtém o campo de email do fomulário de contato
     *
     * Obs.: não retorna o objeto, retorna o valor preenchido do campo email_form_contact
     *
     * @return String
     */
    public function getEmailFormContact()
    {
        $this->arrayField = [
            'email_form_contact'
        ];

        $settings =  $this->findById(1);

        return $settings->email_form_contact;
    }
    
}