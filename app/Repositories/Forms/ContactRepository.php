<?php

namespace App\Repositories\Forms;

use App\Repositories\BaseRepository;
use App\Repositories\Traits\SendEmailTrait;
use App\Repositories\SettingsRepository;
use App\Exceptions\PersistenceException;
use App\Models\Forms\Contact;

/**
 * Classe responsável por gerenciar as regras de negócio da Model do Formulário de Contato
 */
class ContactRepository extends BaseRepository
{
    use SendEmailTrait;

    /**
     * Model do qual serão executadas as querys
     * @var \App\Models\Forms\Contact
     */
    protected $model  = \App\Models\Forms\Contact::class;

    private $settingsRepository;
    /**
     * Método construtor
     */
    public function __construct( )
    {
        parent::__construct();
        $this->settingsRepository = new SettingsRepository();
    }

        /**
         *
         * @param array $arrayDataForm
         * @param type $sentBy
         * @return type
         * @throws PersistenceException
         */
    public function saveAndSend($arrayDataForm, $sentBy)
    {

        //persiste dados do formulário
        $contactSave = $this->save($arrayDataForm);

        if( !$contactSave )
        {
            throw new PersistenceException('Problemas ao registrar seu contato, por favor tente novamente.');
        }

        $this->arrayData = $contactSave->toArray();

        $this->arrayData['sent_by'] = Contact::$sentBy[$sentBy];

        $this->view = 'email.contact-admin';
        $this->replyTo = $contactSave->email;
        $this->replyName = $contactSave->name;

        //seta email destinatário
        $this->emailTo = $this->settingsRepository->getEmailFormContact();

        $this->name = Contact::$sentBy[$sentBy]; //nome do formulário dinâmico, de acordo com a área que enviou
        $this->subject = 'Contato do site: '.Contact::$sentBy[$sentBy];

        $this->sendEmail();

        /**
         * retornando msg da persistencia
         */
        return array( "message" =>  "Contato enviado com sucesso! Aguarde o contato de nossa equipe");


    }

    /**
     * [save description]
     * @param  [Array] $data Dados para inserção
     *
     * @return [Array|Exception]
     */
    public function save($data)
    {
        $save =  parent::create($data);

        return $save;
    }


}
