<?php
namespace App\Http\Request\Worker\Certification;

use Dingo\Api\Http\FormRequest;

class WorkerCertificationStoreRequest extends FormRequest
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
            'certification_id' => 'required',
            'start_date'       => 'required',
        ];
    }
}