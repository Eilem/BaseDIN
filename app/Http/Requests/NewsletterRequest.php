<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class NewsletterRequest extends FormRequest {

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
            'email'                  => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'name.required'       => "Nome é obrigatório",
            'email.required'      => "Email é obrigatório",
            'email.email'         => "Formato de email inválido",
        ];
  }

    public function formatErrors(Validator $validator)
    {
        return $validator->errors()->toArray();
    }

}