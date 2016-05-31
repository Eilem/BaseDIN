<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\SettingsPresenter;
use Robbo\Presenter\PresentableInterface;

class Settings extends Model implements PresentableInterface
{

    protected $table = 'settings';

    protected $primaryKey = 'id_settings';
    
    public $timestamps = false;
    
     /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
      	'id_settings',
        'home_title',
        'home_description',
        'title',
        'description',
        'contact_address' ,
        'contact_address_latitude',
        'contact_address_longitude',
        'contact_email' ,
        'contact_phone',
        'email_form_contact',
        'google_analytcs'
    ];


    public function getPresenter()
    {
        return new SettingsPresenter($this);
    }

}
