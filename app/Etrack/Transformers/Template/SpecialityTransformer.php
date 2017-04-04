<?php

namespace App\Etrack\Transformers\Template;

use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Template\Speciality;

/**
 * Class SpecialityTransformer
 * @package namespace App\Etrack\Transformers\Template;
 */
class SpecialityTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company'
    ];
    /**
     * Transform the \Speciality entity
     * @param \Speciality $model
     *
     * @return array
     */
    public function transform(Speciality $model)
    {
        return [
            'id'         => (int) $model->id,
            'company_id' => $model->company_id,
            'name'       => $model->name,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeCompany(Speciality $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }
}
