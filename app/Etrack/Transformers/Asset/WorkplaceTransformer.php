<?php

namespace App\Etrack\Transformers\Asset;

use App\Etrack\Entities\Assets\Workplace;
use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class WorkplaceTransformer
 * @package namespace App\Etrack\Transformers\Asset;
 */
class WorkplaceTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company',
        'assets'
    ];

    /**
     * Transform the \Workplace entity
     * @param Workplace $model
     *
     * @return array
     */
    public function transform(Workplace $model)
    {
        return [
            'id'         => (int)$model->id,
            'name'       => $model->name,
            'latitude'   => (float)$model->latitude,
            'longitude'  => (float)$model->longitude,
            'created_at' => $model->created_at ? $model->created_at->format('d/m/Y') : null,
        ];
    }

    public function includeCompany(Workplace $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeAssets(Workplace $model)
    {
        return $this->collection($model->assets, new AssetTransformer(), 'parent');
    }
}
