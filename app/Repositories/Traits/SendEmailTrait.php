<?php

namespace App\Repositories\Traits;

use Mail;
use App\Exceptions\EmailException;
use Exception;
use Illuminate\Support\Facades\Log;


//teste para validação do tipo do email
use Validator;



trait SendEmailTrait
{
    /**
     * View do email
     * @var view
     */
    protected $view;

   /*
    * Campos a serem enviados popr email
    */
    protected $arrayData;

    /**
     * Título do usuário do email, setado no .env na variável "MAIL_USERNAME"
     * @var String
     */
    private $from;

    /**
     *
     * @var Array  Lista de emails ao qual o email será enviado
     */
    protected $emailTo = array();

    /**
     * Nome exibido no email enviado ( Contato)
     * @var String
     */
    protected $name;

    /**
     * Assunto do email enviado
     * @var String
     */
    protected $subject;

    /**
     * Responser para...
     * Email do Usuário para quem esse email será respondido
     * @var String
     */
    protected $replyTo;

    /**
     * Nome do Usuário para quem esse email será respondido
     * @var String
     */
    protected $replyName;

    /**
     * Efetua o envio do email a partir dos dados setados
     * @return type
     */
    public function sendEmail()
    {
        $this->from = getenv('MAIL_USERNAME');

        //dados enviados por email
        $data = $this->arrayData;

        // tratando o valor de emailTo , quebrando em array
        $this->emailTo = $this->prepareArrayEmail();
        
        //verificando se todos os emails são corretos.
        $this->emailTo = $this->validateArrayEmail( $this->emailTo );

        if( ! count(  $this->emailTo ) )
        {
            $erro = "Nenhum e-mail válido definido para envio."; 
            Log::error( $erro . " Lista de e-mail de destinatário vazia. ", ['SendEmailTrait', 'sendEmail'] );
            throw new EmailException($erro );
        }
        
        try{

            return Mail::send(
                    $this->view,
                    [ 'data' => $data] ,
                    function ($m){

                        $m->from($this->from, getenv("APPLICATION_NAME")); // sistema q envia

                        $firstEmail = $this->emailTo[0];
                        $m->to($firstEmail, $this->name); //;primeiro email

                        if( count($this->emailTo) > 1 )
                        {
                     
                           /**
                            * Setando cópias de envio do email
                            */
                            foreach($this->emailTo as $key => $toCc)
                            {
                                if($key != 0)
                                {
                                    $m->cc($toCc , $this->name);
                                }
                            }
                           
                        }

                        $m->replyTo($this->replyTo,  $this->replyName ); //user
                        $m->subject($this->subject);
                    }
            );

        } catch (Exception $ex) {

            Log::error( $ex->getMessage(), ['SendEmailTrait', 'sendEmail'] );
            throw new EmailException('Desculpe, ocorreu algum problema ao enviar o email, por favor tente novamente.');
        }

    }

    /**
     * Transforma a string de emails separada por virgula em um array de emails
     *
     * @return Array
     */
    protected function prepareArrayEmail()
    {
        $arrayEmail = explode(',', $this->emailTo );

        return $arrayEmail;
    }

    
    protected function validateArrayEmail( $arrayEmail ) 
    {
        $newArray = array();
        
        foreach( $arrayEmail as $key => $currentEmail )
        {
            $currentEmail = str_replace(" ", "", $currentEmail);
            
            $emailInvalid = $this->validateEmail($currentEmail);

            if($emailInvalid)
            {
                Log::info( "Email: " . $currentEmail . " na  posição: ".$key." da lista de emails tem formato inválido " , ['SendEmailTrait', 'validateArrayEmail'] ); 
                Log::error( "Email: " . $currentEmail . " na  posição: ".$key." da lista de emails tem formato inválido " , ['SendEmailTrait', 'validateArrayEmail'] ); 
                
                continue; //email tem formato inválido , continuando a lista de emails
            }
            
            $newArray[] = $currentEmail;
        }
        
        //retorna a "nova" lista de email, contendo apenas emails válidos 
        return $newArray;
    }  

    

    /**
     * Valida o email antes de enviar
     * retorna true se ouver erro do email
     * e false se o email for válido (email sem erros)
     *
     * @param  [String] $email [description]
     * @return [type]        bollean false | Validation
     */
    private function validateEmail($email)
    {
        
        $dadaValidation = array(
            'email' => $email
        );

        $ruleVaslidation = array(
            'email' => 'email'
        );

        $validator = Validator::make($dadaValidation, $ruleVaslidation);
        return $validator->fails();
    }


}
