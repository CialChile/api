<?php

namespace App\Etrack\Transformers;

use App\Etrack\Transformers\Asset\AssetTransformer;
use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Status;

/**
 * Class StatusTransformer
 * @package namespace App\Etrack\Transformers;
 */
class StatusTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'company',
        'assets'
    ];

    /**
     * Transform the \Status entity
     * @param Status $model
     *
     * @return array
     */
    public function transform(Status $model)
    {
        return [
            'id'   => (int)$model->id,
            'name' => $model->name,
            'type' => $model->type,
        ];
    }

    public function includeCompany(Status $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeAssets(Status $model)
    {
        return $this->collection($model->assets, new AssetTransformer(), 'parent');
    }
}
