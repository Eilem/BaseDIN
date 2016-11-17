<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Robbo\Presenter\PresentableInterface;
use App\Presenters\PagePresenter;

/**
 * Model da Entidade Page
 */
class Page extends Model implements PresentableInterface
{

    /**
     * Tabela do banco onde a entidade Page é persistida
     * @var String
     */
    protected $table = 'page';


    /**
     * Chave primária da tabela
     * @var String
     */
    protected $primaryKey = 'id_page';

    /**
     *
     * @var Array Campos
     */
    protected $fillable = [
        'id_page',
        'id_page_cat',
        'title',
        'content',
        'sequence',
        'cover',
        'description',
        'uri',
        'url',
        'target',
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
     * @var string
     */
    protected $connection = 'mysql';



    /**
     * Presenter da PageModel
     * Classe responsável por "decorar" as propriedades do objeto da classe a
     * qual representa
     *
     * @return PagePresenter
     */
    public function getPresenter()
    {
        return new PagePresenter($this);
    }

    /**
     * Item do menu ao qual a página pertence
     * @return \App\Models\PageCat
     */
    public function menu()
    {
        return $this->belongsTo('App\Models\PageCat', 'id_page_cat', 'id_page_cat');
    }

}
