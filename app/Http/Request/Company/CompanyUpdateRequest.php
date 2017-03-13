<?php
namespace App\Http\Request\Company;

use App\Etrack\Entities\Auth\User;
use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends FormRequest
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
        $user = User::where('company_id', $this->route('company'))->where('company_admin', true)->first();
        return [
            'responsible.email'        => ['email',
                                           Rule::unique('users', 'email')->ignore($user->id),
                                           'required'],
            'responsible.first_name'   => 'required',
            'responsible.last_name'    => 'required',
            'responsible.position'     => 'required',
            'responsible.rut_passport' => 'required',
            'name'                     => 'required',
            'commercial_name'          => 'required',
            'email'                    => 'email|required',
            'fiscal_identification'    => 'required',
            'field_id'                 => 'required',
            'country'                  => 'required',
            'state'                    => 'required',
            'city'                     => 'required',
            'address'                  => 'required',
            'zip_code'                 => 'required',
            'users_number'             => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'responsible.email.unique' => 'Ya existe un usuario con ese correo electrónico.',
        ];
    }

    public function attributes()
    {
        return [
            'responsible.email'        => 'correo Electrónico del usuario administrador',
            'responsible.first_name'   => 'nombre del usuario administrador',
            'responsible.last_name'    => 'apellido del usuario administrador',
            'responsible.position'     => 'cargo del usuario administrador',
            'responsible.rut_passport' => 'Rut/Pasaporte del usuario administrador',
        ];
    }
}