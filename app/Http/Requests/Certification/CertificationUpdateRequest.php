<?php
namespace App\Http\Requests\Certification;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class CertificationUpdateRequest extends FormRequest
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
            'institute_id'  => 'required',
            'type'          => 'required',
            'status_id'     => 'required',
            'validity_time' => 'required',
            'sku'           => ['required', Rule::unique('certifications', 'sku')->ignore($this->route('certification'))],
            'name'          => 'required',
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
            'sku.unique' => 'Ya existe una certificación con ese código de identificación.',
        ];
    }

    public function attributes()
    {
        return [
            'sku'           => 'código de identificación',
            'name'          => 'nombre',
            'validity_time' => 'tiempo de validez',
            'type'          => 'Aplica A',
        ];
    }
}