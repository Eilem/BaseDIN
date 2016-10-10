<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Repositories\Forms\NewsletterRepository;
use App\Http\Requests\NewsletterRequest;
use Exception;
use App\Exceptions\PatternException;
use App\Exceptions\PersistenceException;

class NewsletterController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository =  new NewsletterRepository();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function create(NewsletterRequest $request)
    {
        $dadosRequest = $request->all();

        try {

            $newsletter = $this->repository->create($dadosRequest);
            return response()->json($newsletter , 201);

        }catch (PersistenceException $ex){

            return $ex->getJsonMessage();

        }catch (Exception $ex){

            return PatternException::getJsonMessage();
        }
    }


}
