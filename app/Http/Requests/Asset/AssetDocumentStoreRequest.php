<?php
namespace App\Http\Requests\Asset;

use Dingo\Api\Http\FormRequest;

class AssetDocumentStoreRequest extends FormRequest
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
            'documents.*' => 'required|mimes:pdf,docx,xlsx'
        ];
    }

    public function messages()
    {
        return [
            'documents.*.mimes' => 'El documento debe tener la extension docx, xlsx o pdf',
        ];
    }

}