<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;

class SettingsPresenter extends BasePresenter
{

    public function presentColPhoneString() 
    {
        return str_replace(',', ' / ', $this->contact_phone);
        
    }
    
    /**
     * Retorna apenas o primeiro telefone que foi cadastrado em Settings
     *
     * @return string Telefone
     */
    public function presentFirstPhone()
    {
        if( empty($this->contact_phone) )
        {
            return "";
        }

        $colPhone  = explode(',', $this->contact_phone);

        if( count($colPhone) )
        {
            return $colPhone[0];
        }

    }

    public function presentListColPhone()
    {
        return str_replace(',', '<br/>', $this->contact_phone);
    }

    /**
    * Decorator Endereço com quebra de linha
    * @return string
    */
     public function presentAddressWithBreak()
     {
         return nl2br($this->address);
     }

    
}