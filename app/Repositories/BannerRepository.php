<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Banner;

/**
 * Classe responsável por obter as informações de Banner obedecendo as regras de
 *  negócio da Model Banner
 */
class BannerRepository extends BaseRepository
{
    /**
     * Model do qual serão executadas as querys
     * @var \App\Models\Banner
     */
    protected $model  = \App\Models\Banner::class;

    /**
     * Método construtor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtém uma lista ordenada por sequência de banners ativos de acordo
     * com os parâmetros recebidos
     *
     * @param String $position  Tipo do banner a ser retornado
     * @param Int    $limit     Quantidade de banners a ser retornada
     *
     * @return Collection Banner
     */
    public function getColByPosition( $position,  $limit = null)
    {
        $this->isActive();
        $this->isDel();
        $this->query->where('position', $position);
        $this->query->whereNotNull('file');
        $this->orderBy('sequence');
        $this->limit = $limit;

        $this->arrayField = [
          'id_banner',
          'title',
          'url' ,
          'file',
          'position',
          'target'
        ];

        $colBanner = $this->doQuery();

        return $colBanner;
    }

}
