<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Robbo\Presenter\PresentableInterface;
use App\Presenters\ClassPresenter;

/**
 * Model da Entidade 
 */
class ClassModel extends Model implements PresentableInterface
{
    
    /**
     * Tabela do banco onde a entidade é persistida
     * @var String
     */
    protected $table = 'table';

     
    /**
     * Chave primária da tabela
     * @var String
     */
    protected $primaryKey = 'id';

    /**
     *
     * @var type Campos
     */
    protected $fillable = [  ];

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
     * Indicates if the IDs are auto-incrementing.
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
     * Presenter da ClassModel
     * Classe responsável por "decorar" as propriedades do objeto da classe a 
     * qual representa
     * 
     * @return ClassPresenter
     */
    public function getPresenter()
    {
        return new ClassPresenter($this);
    }

}
