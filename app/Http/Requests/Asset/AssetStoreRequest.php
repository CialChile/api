<?php

namespace App\Http\Requests\Asset;


use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetStoreRequest extends FormRequest
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
            'sku'                   => [Rule::unique('assets', 'sku')->whereNull('deleted_at'),
                                        'required'],
            'name'                  => 'required',
            'category_id'           => 'required',
            'brand_id'              => 'required',
            'workplace_id'          => 'required',
            'worker_id'             => 'required',
            'status_id'             => 'required',
            'serial'                => 'required',
            'validity_time'         => 'required',
            'integration_date'      => 'required',
            'end_service_life_date' => 'required',
        ];
    }
}
