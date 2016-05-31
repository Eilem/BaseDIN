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
     * retorna o primeiro telefone de contato
     * @return string
     */
    public function presentFirstPhone() 
    {
        $colPhone  = explode(',', $this->contact_phone);
        
        if($colPhone)
        {
            return $colPhone[0];
        }
        
    }

    
    public function presentListColPhone() 
    {
        return str_replace(',', '<br/>', $this->contact_phone);
    }
    
}