<?php

namespace App\Etrack\Transformers\Asset;

use App\Etrack\Entities\Assets\BrandModel;
use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class BrandModelTransformer
 * @package namespace App\Etrack\Transformers\Asset;
 */
class BrandModelTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company',
        'assets',
        'brand'
    ];

    /**
     * Transform the \BrandModel entity
     * @param BrandModel $model
     *
     * @return array
     */
    public function transform(BrandModel $model)
    {
        return [
            'id'         => (int)$model->id,
            'brand_id'   => (int)$model->brand_id,
            'name'       => $model->name,
            'created_at' => $model->created_at ? $model->created_at->format('d/m/Y') : null
        ];
    }

    public function includeCompany(BrandModel $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeAssets(BrandModel $model)
    {
        return $this->collection($model->assets, new AssetTransformer(), 'parent');
    }

    public function includeBrand(BrandModel $model)
    {
        return $this->item($model->brand, new BrandTransformer(), 'parent');
    }
}
