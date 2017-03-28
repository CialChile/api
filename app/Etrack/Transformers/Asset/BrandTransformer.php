<?php

namespace App\Etrack\Transformers\Asset;

use App\Etrack\Entities\Assets\Brand;
use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class BrandTransformer
 * @package namespace App\Etrack\Transformers\Asset;
 */
class BrandTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'company',
        'assets'
    ];

    /**
     * Transform the \Brand entity
     * @param Brand $model
     *
     * @return array
     */
    public function transform(Brand $model)
    {
        return [
            'id'         => (int)$model->id,
            'name'       => $model->name,
            'created_at' => $model->created_at ? $model->created_at->format('d/m/Y') : null
        ];
    }

    public function includeCompany(Brand $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeAssets(Brand $model)
    {
        return $this->collection($model->assets, new AssetTransformer(), 'parent');
    }
}
