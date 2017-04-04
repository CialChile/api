<?php

namespace App\Etrack\Transformers\Template;

use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Template\TemplateType;

/**
 * Class TemplateTypeTransformer
 * @package namespace App\Etrack\Transformers\Template;
 */
class TemplateTypeTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company'
    ];
    /**
     * Transform the \TemplateType entity
     * @param \TemplateType $model
     *
     * @return array
     */
    public function transform(TemplateType $model)
    {
        return [
            'id'          => (int) $model->id,
            'company_id'  => $model->company_id,
            'name'        => $model->name,
            'created_at'  => $model->created_at,
            'updated_at'  => $model->updated_at
        ];
    }

    public function includeCompany(TemplateType $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }
}
