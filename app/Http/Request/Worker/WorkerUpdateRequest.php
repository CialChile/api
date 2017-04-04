<?php
namespace App\Http\Request\Worker;

use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\Worker\Worker;
use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkerUpdateRequest extends FormRequest
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
            'first_name'          => 'required',
            'last_name'           => 'required',
            'rut_passport'        => 'required',
            'email'               => ['email',
                                      Rule::unique('workers', 'email')->ignore($this->route('worker')),
                                      'required'],
            'position'            => 'required',
            'birthday'            => 'required',
            'country'             => 'required',
            'state'               => 'required',
            'city'                => 'required',
            'address'             => 'required',
            'zip_code'            => 'required',
            'emergency_telephone' => 'required',
            'emergency_contact'   => 'required',
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
        ];
    }
}