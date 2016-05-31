<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Robbo\Presenter\PresentableInterface;
use App\Presenters\ClassPresenter;

class ClassModel extends Model
{

    protected $table = 'table';

	  protected $primaryKey = 'id';

    protected $fillable = [  ];

    public $timestamps = false;


    public function getPresenter()
    {
        return new ClassPresenter($this);
    }

}
