<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Robbo\Presenter\PresentableInterface;
use App\Presenters\PageCatPresenter;

/**
 * Model da Entidade PageCat(table)
 */
class PageCat extends Model implements PresentableInterface
{

    /**
     * Tabela do banco onde a entidade PageCat é persistida
     * @var String
     */
    protected $table = 'page_cat';


    /**
     * Chave primária da tabela
     * @var String
     */
    protected $primaryKey = 'id_page_cat';

    /**
     * Campos da entidade
     * @var Array Campos
     */
    protected $fillable = [
        'id_page_cat',
        'title',
        'content',
        'sequence',
        'cover',
        'description',
        'uri',
        'url',
        'target',
        'type',
        'is_active',
        'inc_date',
        'is_del',
        'date_del',
    ];

    protected $hidden = [
        'date_del',
        'is_del',
        'is_active',
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
     * Tipo do menu Superior
     * @var String
     */
      static $typeTop = 'top';


    /**
     * Tipo do menu Oculto
     * @var String
     */
    static $typeHidden = 'hidden';



    /**
     * Presenter da PageCatModel
     * Classe responsável por "decorar" as propriedades do objeto PageCat
     *
     * @return PageCatPresenter
     */
    public function getPresenter()
    {
        return new PageCatPresenter($this);
    }

    /**
     * Coleção de objetos das páginas ativas que pertencem ao Menu
     * @return Collection
     */
    public function colPage()
    {
    return $this->hasMany('App\Models\Page', 'id_page_cat', 'id_page_cat')
                ->where('is_active',1)
                ->where('is_del',0)
                ->orderBy('sequence', 'asc');
    }

}
