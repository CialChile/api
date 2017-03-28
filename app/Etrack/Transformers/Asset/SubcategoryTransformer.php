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
        'assets',
        'category'
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
            'category_id' => (int)$model->category_id,
            'name'        => $model->name,
            'created_at'  => $model->created_at ? $model->created_at->format('d/m/Y') : null,
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

    public function includeCategory(Subcategory $model)
    {
        return $this->item($model->category, new CategoryTransformer(), 'parent');
    }
}
