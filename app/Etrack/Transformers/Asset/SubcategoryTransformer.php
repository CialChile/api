<?php

namespace App\Etrack\Transformers\Asset;

use App\Etrack\Entities\Assets\Subcategory;
use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class SubcategoryTransformer
 * @package namespace App\Etrack\Transformers\Asset;
 */
class SubcategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company',
        'assets'
    ];

    /**
     * Transform the \Subcategory entity
     * @param Subcategory $model
     *
     * @return array
     */
    public function transform(Subcategory $model)
    {
        return [
            'id'          => (int)$model->id,
            'category_id' => (int)$model->id,
            'name'        => $model->name,
        ];
    }

    public function includeCompany(Subcategory $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeAssets(Subcategory $model)
    {
        return $this->collection($model->assets, new AssetTransformer(), 'parent');
    }
}
