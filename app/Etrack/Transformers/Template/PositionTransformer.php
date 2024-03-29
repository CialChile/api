<?php

namespace App\Etrack\Transformers\Template;

use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Template\Position;

/**
 * Class PositionTransformer
 * @package namespace App\Etrack\Transformers\Template;
 */
class PositionTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company'
    ];
    /**
     * Transform the \Position entity
     * @param Position $model
     *
     * @return array
     */
    public function transform(Position $model)
    {
        return [
            'id'         => (int) $model->id,
            'company_id' => $model->company_id,
            'name'       => $model->name,
            'created_at' => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at' => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }

    public function includeCompany(Position $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }
}
