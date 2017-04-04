<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Activity\Periodicity;

/**
 * Class PeriodicityTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class PeriodicityTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company'
    ];
    /**
     * Transform the \Periodicity entity
     * @param Periodicity $model
     *
     * @return array
     */
    public function transform(Periodicity $model)
    {
        return [
            'id'         => (int) $model->id,
            'company_id' => $model->company_id,
            'times'      => $model->times,
            'description'=> $model->description,
            'created_at' => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at' => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }

    public function includeCompany(Periodicity $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }
}