<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Robbo\Presenter\PresentableInterface;
use App\Presenters\BannerPresenter;

/**
 * Model da Entidade Banner
 */
class Banner extends Model implements PresentableInterface
{

    /**
     * Tabela do banco onde a entidade Banner é persistida
     * @var String
     */
    protected $table = 'banner';


    /**
     * Chave primária da tabela
     * @var String
     */
    protected $primaryKey = 'id_banner';

    /**
     *
     * @var type Campos
     */
    protected $fillable = [
        'id_banner',
        'title',
        'url',
        'target',
        'file',
        'position',
        'sequence',
        'is_active',
        'inc_date',
        'is_del',
        'date_del',
    ];

    /**
     * <b>Obs.:</b> configuração do Framework Laravel para salvar timestamp de
     * created_at e updated_at "automaticamente" nos métodos de persistência.
     *
     * true : Persistir timestamps
     * false : Não persistir timestamps
     * @var boolean
     */
    public $timestamps = false;


    protected $hidden = [
        'date_del',
        'is_del',
        'is_active',
    ];

    /**
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Banco onde se encontram os dados da entidade, definidos no arquivo :
     * \config\database no array connections.
     *
     * @var String
     */
    protected $connection = 'mysql';

    /**
     * Posição Home do banner
     * @var String
     */
    static $positionHome = 'home';


    /**
     * Presenter da BannerModel
     * Classe responsável por "decorar" as propriedades do objeto Banner
     *
     * @return BannerPresenter
     */
    public function getPresenter()
    {
        return new BannerPresenter($this);
    }

}
