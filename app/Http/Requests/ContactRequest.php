<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ContactRequest extends FormRequest {

    public function authorize()
    {
        return true;
    }

    /**
     * Json
     * @return boolean
     */
   public function wantsJson()
   {
       return true;
   }

    public function rules()
    {

        return [
            'name'                   => 'required',
            'phone'                  => 'required',
            'email'                  => 'required|email',
            'message'                => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'       => "Nome é obrigatório.",
            'phone.required'      => "Telefone é obrigatório.",
            'email.required'      => "Email é obrigatório.",
            'email.email'         => "Formato de email inválido.",
            'message.required'    => "Mensagem é obrigatória.",
        ];
  }

    public function formatErrors(Validator $validator)
    {
        return $validator->errors()->toArray();
    }

}
