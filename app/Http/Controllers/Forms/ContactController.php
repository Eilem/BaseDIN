<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Repositories\Forms\ContactRepository;
use App\Http\Requests\ContactRequest;
use Exception;
use App\Exceptions\PatternException;
use App\Exceptions\PersistenceException;
use App\Exceptions\EmailException;
use App\Models\Forms\Contact;

class ContactController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository =  new ContactRepository();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function create(ContactRequest $request)
    {
       $dadosRequest = $request->all();

        try {
          
            $response = $this->repository->saveAndSend($dadosRequest , Contact::$sentByContact);
            return response()->json($response , 201);

        }catch (PersistenceException $ex){

            return $ex->getJsonMessage();

        }catch (EmailException $ex){

            return $ex->getJsonMessage();

        }catch (Exception $ex){

            return PatternException::getJsonMessage();
        }
    }


}
