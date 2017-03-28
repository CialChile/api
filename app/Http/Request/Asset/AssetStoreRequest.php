<?php

namespace App\Http\Request\Asset;


use Dingo\Api\Http\FormRequest;

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
            'sku'                   => 'required|unique:assets,sku',
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
