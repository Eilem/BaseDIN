<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\AbstractPaginator as Paginator;
use App\Repositories\iRepositories\iBaseRepository;

abstract class BaseRepository //implements iBaseRepository
{

    /**
     * Classe da Entidade definida para as querys do repositório
     *
     * @var string
     */
    protected $model;

    /**
     * Query
     * @var
     */
    protected $query;

    /**
     *
     * Array contendo os campos que devem ser
     * retornados na busca,
     * array vazio retorna todos os campos da Entidade
     *
     * @var Array
     */
    protected $arrayField = array();

    /**
     * Limit para consulta
     * Quantidade retornada na busca
     * @var int
     */
    protected $limit = null; // = getenv('LIMIT');


    /**
    * relacionamentos
    */
    protected $with = array();

    public function __construct()
    {
        $this->model = app($this->model);

        /**
         * Set a EloquentQueryBuilder|QueryBuilder in $this->model
         */
        $this->query = $this->model->newQuery();
    }

    public static function setId()
    {
    	return md5(uniqid());
    }

    /**
     * Executa a query da entidade definida na variável $modelClass
     *
     * @param EloquentQueryBuilder|QueryBuilder $query
     *
     * @param bool $paginate retorno da busca com ou sem paginaçào
     *
     * @param type $appends
     *
     * @return EloquentCollection|Paginator
     */
    protected function doQuery($query = null, $paginate = false , $appends = null)
    {
        if (is_null($query))
        {
            $query = $this->query;
        }

        if ($paginate == true ) {

            if($appends)
            {
                return $query->paginate($this->limit)->appends($appends);
            }

            return $query->paginate($this->limit);
        }

        if ($this->limit > 0 || !is_null($this->limit))
        {
            $query->limit($this->limit);
        }

        //verificando se deve trazer todos os atributos ou somente os atributos definidos em $arrayField
        if(!count($this->arrayField))
        {
            return $query->get();
        }

        return $query->get($this->arrayField);

    }

    /**
     * Returns all records.
     * @return EloquentCollection|Paginator
     */
    public function getAll()
    {
        return $this->doQuery( );
    }


    /**
     * Get onde record.
     * @return Entity
     */
    public function getOne()
    {
        if(!count($this->arrayField))
        {
            return $this->query->first();
        }

        return $this->query->first($this->arrayField);
    }


    /**
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($column, $key = null)
    {
        return $this->query->lists($column, $key);
    }

    /**
     * Set With
     * @return type
     */
    public function setWith( )
    {
        return $this->query->with($this->with);
    }

    /**
     * Active
     * @param type $isActive
     * @param string
     * @return type
     */
    public function isActive($isActive = 1, $field = null )
    {
        if(is_null($field))
        {
            $field = getenv('ACTIVE_FIELD');
        }
        return $this->query->where($field, $isActive);
    }

    /**
     * IsDel
     * @param type $isDel
     * @return type
     */
    public function isDel( $isDel = 0 , $field = null )
    {
        if(is_null($field))
        {
            $field = getenv('DEL_FIELD');
        }
        return $this->query->where($field, $isDel);
    }


    /**
     * Define order by no select
     * @param string $field
     * @param string $order
     * @return type
     */
    public function orderBy($field, $order = 'asc')
    {
        return $this->query->orderBy( $field, $order );
    }


    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int  $id
     * @param bool $fail
     *
     * @return Model
     */
    public function findById($id )
    {
        //verificando se deve trazer todos os atributos ou somente os atributos definidos em $arrayField
        if(!count($this->arrayField))
        {
            return $this->query->findOrFail($id);
        }

        return $this->query->findOrFail($id, $this->arrayField);
    }


    /**
    * Persiste a entidade com parametros recebidos no parâMultipleIterator
    * @param array $input
    */
    public function create($input)
    {
        return $this->model->create($input);
    }


}
