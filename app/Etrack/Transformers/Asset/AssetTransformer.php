<?php

namespace App\Etrack\Transformers\Asset;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Transformers\Company\CompanyTransformer;
use App\Etrack\Transformers\StatusTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class AssetTransformer
 * @package namespace App\Etrack\Transformers\Asset;
 */
class AssetTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'company',
        'worker',
        'brand',
        'brandModel',
        'status',
        'category',
        'subcategory'
    ];

    /**
     * Transform the \Asset entity
     * @param Asset $model
     *
     * @return array
     */
    public function transform(Asset $model)
    {
        return [
            'id'                    => (int)$model->id,
            'tag_rfid'              => $model->tag_rfid,
            'location'              => $model->location,
            'sku'                   => $model->sku,
            'serial'                => $model->serial,
            'validity_time'         => $model->validity_time,
            'integration_date'      => $model->integration_date,
            'end_service_life_date' => $model->end_service_life_date,
            'warranty_date'         => $model->warranty_date,
            'disincorporation_date' => $model->disincorporation_date,
            'custom_fields'         => $model->custom_fields,
            'created_at'            => $model->created_at,
            'updated_at'            => $model->updated_at
        ];
    }

    public function includeCompany(Asset $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeWorker(Asset $model)
    {
        $worker = $model->worker;
        if ($worker) {
            return $this->item($worker, new CompanyTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeBrand(Asset $model)
    {
        return $this->item($model->brand, new BrandTransformer(), 'parent');

    }

    public function includeBrandModel(Asset $model)
    {
        $brandModel = $model->brandModel;
        if ($brandModel) {
            return $this->item($brandModel, new BrandModelTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeStatus(Asset $model)
    {
        return $this->item($model->status, new StatusTransformer(), 'parent');

    }

    public function includeCategory(Asset $model)
    {
        return $this->item($model->category, new CategoryTransformer(), 'parent');

    }

    public function includeSubcategory(Asset $model)
    {
        $subcategory = $model->subcategory;
        if ($subcategory) {
            return $this->item($subcategory, new SubcategoryTransformer(), 'parent');
        }
        return $this->null();
    }
}
