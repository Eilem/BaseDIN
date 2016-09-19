<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\AbstractPaginator as Paginator;

abstract class BaseRepository
{

    /**
     * Classe da Entidade definida para as querys do repositório
     *
     * @var string
     */
    protected $model;

    /**
     * [$modelApp description]
     * @var srtring
     */
    private $modelApp;


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

    /**
     * Método construtor
     */
    public function __construct()
    {
        $this->makeModel();
    }


    /**
     * 
     * Reset model 
     * reseta a query definida 
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
    *
    * Create model set class in model
    */
    public function makeModel()
    {
        $this->modelApp = app($this->model);

        /**
         * Set a EloquentQueryBuilder|QueryBuilder in $this->model
         */
        $this->query = $this->modelApp->newQuery();
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
            $collection =  $query->get();
        }

        $collection =  $query->get($this->arrayField);

        $this->resetModel();

        return $collection;


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

        $result =  $this->query->first($this->arrayField);

        $this->resetModel();

        return $result;
    }


    /**
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($column, $key = null)
    {
        $list =  $this->query->lists($column, $key);

        $this->resetModel();

        return $list;
    }

    /**
     * Seta na query os relacionamentos que devem ser retornados o obter o Objeto
     * Relacionamentos definidos na variável <b>with</b>
     * 
     * @return query
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
            $result =  $this->query->findOrFail($id);
        }

        $result =  $this->query->findOrFail($id, $this->arrayField);

        $this->resetModel();
        return $result;
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
