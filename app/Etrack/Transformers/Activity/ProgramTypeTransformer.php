<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Activity\ProgramType;

/**
 * Class ProgramTypeTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class ProgramTypeTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company'
    ];
    /**
     * Transform the \ProgramType entity
     * @param ProgramType $model
     *
     * @return array
     */
    public function transform(ProgramType $model)
    {
        return [
            'id'         => (int) $model->id,
            'company_id' => $model->company_id,
            'name'       => $model->name,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeCompany(ProgramType $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }
}
