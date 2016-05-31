<?php

namespace App\Repositories\EmailForm;

use Mail;

class EmailBaseRepository
{
    protected $view;
    protected $arrayData;

    private $from;

    protected $emailTo = array();
    protected $name;

    protected $subject;

    protected $replyTo;
    protected $replyName;

    public function sendEmail()
    {
        $this->from = getenv('MAIL_USERNAME');

        $data = $this->arrayData;

        $this->emailTo = $this->prepareArrayEmail();

        return Mail::send($this->view,
                   [ 'data' => $data] ,
                   function ($m)  {

                        $m->from($this->from, getenv("APPLICATION_NAME")); // sistema q envia

                        $m->to($this->emailTo[0], $this->name);  //área

                        if(count($this->emailTo) > 1)
                        {

                          foreach($this->emailTo as $toCc)
                          {
                              $m->cc($toCc , $this->name);
                          }
                        }

                        $m->replyTo($this->replyTo,  $this->replyName ); //user

                        $m->subject($this->subject);

        });

    }

    /**
    * transforma a string de emails separada por virgula em um array de emails
    **/
    protected function prepareArrayEmail()
    {
        $arrayEmail = explode(',', $this->emailTo );

        return $arrayEmail;
    }

}
