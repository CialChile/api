<?php
namespace App\Http\Requests\Worker\Certification;

use Dingo\Api\Http\FormRequest;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class WorkerCertificationDocumentStoreRequest extends FormRequest
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
            'documents.*' => 'required|mimes:pdf,docx,xlsx,jpg,png,jpeg,JPG,JPEG,PNG'
        ];
    }

    public function messages()
    {
        return [
            'documents.*.mimes' => 'El documento debe tener la extension docx, xlsx, pdf, jpg, png o jpeg',
        ];
    }

}