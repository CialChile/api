<?php

namespace App\Etrack\Transformers\Asset;

use App\Etrack\Entities\Assets\Category;
use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class CategoryTransformer
 * @package namespace App\Etrack\Transformers\Asset;
 */
class CategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company',
        'assets'
    ];

    /**
     * Transform the \Category entity
     * @param Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id'   => (int)$model->id,
            'name' => $model->name,
        ];
    }

    public function includeCompany(Category $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeAssets(Category $model)
    {
        return $this->collection($model->assets, new AssetTransformer(), 'parent');
    }
}
