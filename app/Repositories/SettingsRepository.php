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

}