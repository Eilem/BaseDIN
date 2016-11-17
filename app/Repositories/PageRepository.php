<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;

class PageRepository extends BaseRepository
{
    protected $model = \App\Models\Page::class;

    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Get Page by slug
    */
    public function getByUri($slug)
    {
        $uri = '/pagina/'.$slug.'/';

        $this->isActive();
        $this->isDel();
        $this->query->where('uri', $uri);

        $this->arrayField = [
            'id_page',
            'id_page_cat',
            'title',
            'sub_title',
            'content',
            'sequence',
            'cover',
            'description',
            'uri',
            'url'
        ];
        
        $this->with = [ 'menu'];
        $this->setWith();
        
        $page = $this->getOne();
        
        if(!$page)
        {
            Log::error("Página com slug: $slug, não localizado.",['PageRepository', 'getByUri'] );
            throw new NotFoundException("Página não localizado.");
        }

        return $page;
    }

    /**
     * Obtém a página a partir da url recebida no parâmetro
     *
     * @param  [string]   $url [description]
     *
     * @return [\App\Models\Page]  página
     */
    public function getByUrl($url)
    {
        $this->isActive();
        $this->isDel();
        $this->query->where('url',$url);

        $this->with = [ 'menu'];
        $this->setWith();
        
        $page = $this->getOne();
        
        return $page;
    }
    
    
    /**
     * Obtem as Págimas ativas para o Sitemap
     * @return Collection
     */
    public function getToSitemap()
    {
        $this->arrayField = [
            'uri'
        ];
        
        return $this->getAllActive();
    }
    
    /**
     * Obtém todas a s Páginas ativas ordenadas por sequência
     * @return Collection
     */
    public  function getAllActive()
    {
        $this->isActive();
        $this->isDel();

        $this->query->orderBy(\DB::raw('sequence = 0 , sequence, title'), 'asc');

        $col =  $this->doQuery();
        return $col;
    }
  
}
