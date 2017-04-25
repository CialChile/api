<?php
namespace App\Http\Requests\Institute;

use Dingo\Api\Http\FormRequest;

class InstituteStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required',
            'rut'               => 'required',
            'address'           => 'required',
            'city'              => 'required',
            'contact'           => 'required',
            'telephone_contact' => 'required',
            'email_contact'     => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'email_contact'     => 'Correo Electrónico de Contacto',
            'telephone_contact' => 'Teléfono de Contacto',
            'contact'           => 'Contacto',
        ];
    }
}