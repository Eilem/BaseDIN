<?php

namespace App\Repositories\Traits;

use Mail;
use App\Exceptions\EmailException;
use Exception;



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

        try{

            return Mail::send(
                    $this->view,
                    [ 'data' => $data] ,
                    function ($m){

                        $m->from($this->from, getenv("APPLICATION_NAME")); // sistema q envia

                        //validar primeiro email da lista
                        $firstEmail = $this->emailTo[0];

                        $firstEmailInvalid = $this->validateEmail( $firstEmail);
                        if($firstEmailInvalid)
                        {
                           throw new EmailException( trans('traits/send-email.exceptions.invalid_email'));
                        }

                        $m->to($firstEmail, $this->name); //área

                        if(count($this->emailTo) > 1)
                        {
                            $arrayErros = array();

                           /**
                            * Setando cópias de envio do email
                            */
                            foreach($this->emailTo as $toCc)
                            {
                                $emailInvalid = $this->validateEmail($toCc);

                                if($emailInvalid)
                                {
                                    //email é inválido
                                    //@todo
                                    // futuramente lançar no log
                                    // pensar em como informar ao cliente
                                    continue; //email tem formato inválido , continuando a lista de emails
                                }
                                $m->cc($toCc , $this->name);
                            }
                        }

                        $m->replyTo($this->replyTo,  $this->replyName ); //user
                        $m->subject($this->subject);
                    }
            );

        } catch (Exception $ex) {

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


    /**
     * Valida o email antes de enviar
     * retorna true se ouver erro do email
     * e false se o email for válido (email sem erros)
     *
     * @param  [type] $email [description]
     * @return [type]        [description]
     */
    private function validateEmail($email)
    {
          $email =  trim($email); //removendo possíveis espaços da string do email

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
