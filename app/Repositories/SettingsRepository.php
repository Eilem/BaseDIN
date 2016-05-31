<?php

namespace App\Repositories;

use App\Models\Settings;
use App\Repositories\BaseRepository;

class SettingsRepository extends BaseRepository
{
    protected $model = \App\Models\Settings::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        return $this->findById(1);

    }

}