<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

/**
 * Model da Entidade Newsletter
 */
class Newsletter extends Model
{

    /**
     * Tabela do banco onde a entidade Newsletter é persistida
     * @var String
     */
      protected $table = 'newsletter';


    /**
     * Chave primária da tabela
     * @var String
     */
    protected $primaryKey = 'id_newsletter';

    /**
     *
     * @var Array Campos
     */
    protected $fillable = [
        'id_newsletter',
        'name',
        'email',
        'created_at',
        'updated_at'
    ];

    /**
     * <b>Obs.:</b> configuração do Framework Laravel para salvar timestamp de
     * created_at e updated_at "automaticamente" nos métodos de persistência.
     *
     * true : Persistir timestamps
     * false : Não persistir timestamps
     * @var boolean
     */
    public $timestamps = true;

    /**
     *
     * @var boolean
     */
    public $incrementing = true;

    /**
     * Banco onde se encontram os dados da entidade, definidos no arquivo :
     * \config\database no array connections.
     *
     * @var String
     */
    protected $connection = 'mysql';


}
