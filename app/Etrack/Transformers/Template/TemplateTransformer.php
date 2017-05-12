<?php

namespace App\Etrack\Transformers\Template;

use App\Etrack\Transformers\Activity\ProgramTypeTransformer;
use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Template\Template;

/**
 * Class TemplateTransformer
 * @package namespace App\Etrack\Transformers\Template;
 */
class TemplateTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company',
        'programType',
        'template'
    ];

    /**
     * Transform the \Template entity
     * @param Template $model
     *
     * @return array
     */
    public function transform(Template $model)
    {
        return [
            'id'                       => (int)$model->id,
            'company_id'               => $model->company_id,
            'program_type_id'          => $model->program_type_id,
            'name'                     => $model->name,
            'description'              => $model->description,
            'estimated_execution_time' => $model->estimated_execution_time,
            'is_custom'                => $model->is_custom,
            'active'                   => $model->active,
            'created_at'               => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at'               => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }

    public function includeCompany(Template $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeProgramType(Template $model)
    {
        return $this->item($model->programType, new ProgramTypeTransformer(), 'parent');
    }

    public function includeTemplate(Template $model)
    {
        return $this->item($model->template, function ($structure) {
            return $structure;
        }, 'parent');
    }
}
