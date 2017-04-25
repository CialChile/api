<?php
namespace App\Http\Requests\Certification;

use Dingo\Api\Http\FormRequest;

class CertificationDocumentStoreRequest extends FormRequest
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
            'documents.*' => 'required|mimes:pdf,docx,xlsx,jpeg,bmp,png,jpg'
        ];
    }

    public function messages()
    {
        return [
            'documents.*.mimes' => 'El documento debe tener la extension docx, xlsx, pdf, jpeg, bmp o png',
        ];
    }

}