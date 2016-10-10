<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

/**
 * Model da Entidade do Formulário de Contato
 */
class Contact extends Model
{

    /**
     * Tabela do banco onde a entidade Contact é persistida
     * @var String
     */
      protected $table = 'form_contact';


    /**
     * Chave primária da tabela
     * @var String
     */
    protected $primaryKey = 'id_form_contact';

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
     * Id auto incremet
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

    /**
     *
     * @var Array Campos
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message'
    ];

}
