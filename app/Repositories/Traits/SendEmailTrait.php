<?php

namespace App\Repositories\Traits;

use Mail;
use App\Exceptions\EmailException;
use Exception;

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
     * Nome exibido no email enviado (Contato)
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

        $data = $this->arrayData;
        
        // tratando o valor de emailTo , quebrando em array
        $this->emailTo = $this->prepareArrayEmail();
        
        try{
            
            return Mail::send( 
                    $this->view,
                    [ 'data' => $data] ,
                    function ($m){

                        $m->from($this->from, getenv("APPLICATION_NAME")); // sistema q envia
                        
                        $m->to($this->emailTo[0], $this->name);  //área

                        if(count($this->emailTo) > 1)
                        {
                           /**
                            * cópias de envio do email
                            */
                            foreach($this->emailTo as $toCc)
                            {
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

}
