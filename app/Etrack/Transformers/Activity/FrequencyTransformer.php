<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Activity\Frequency;

/**
 * Class FrequencyTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class FrequencyTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company'
    ];
    /**
     * Transform the \Frequency entity
     * @param Frequency $model
     *
     * @return array
     */
    public function transform(Frequency $model)
    {
        return [
            'id'          => (int) $model->id,
            'company_id'  => $model->company_id,
            'name'        => $model->name,
            'description' => $model->description,
            'created_at' => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at' => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }

    public function includeCompany(Frequency $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }
}