<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Transformers\Company\CompanyTransformer;
use App\Etrack\Transformers\Template\MeasureUnitTransformer;
use App\Etrack\Transformers\Template\TemplateTransformer;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Activity\Activity;

/**
 * Class ActivityTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class ActivityTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company',
        'programType',
        'measureUnit',
        'template'
    ];

    /**
     * Transform the \Activity entity
     * @param Activity $model
     *
     * @return array
     */
    public function transform(Activity $model)
    {
        return [
            'id'              => (int)$model->id,
            'company_id'      => $model->company_id,
            'program_type_id' => $model->program_type_id,
            'measure_unit_id' => $model->measure_unit_id,
            'template_id'     => $model->template_id,
            'number'          => $model->number,
            'name'            => $model->name,
            'description'     => $model->description,
            'process_type'    => $model->process_type,
            'estimated_time'  => $model->estimated_time,
            'start_date'      => $model->start_date ? $model->start_date->format('d/m/Y') : null,
            'end_date'        => $model->end_date ? $model->end_date->format('d/m/Y') : null,
            'start_hour'      => $model->start_hour,
            'end_hour'        => $model->end_hour,
            'validity'        => $model->validity,
            'created_at'      => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at'      => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }

    public function includeCompany(Activity $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeProgramType(Activity $model)
    {
        return $this->item($model->programType, new ProgramTypeTransformer(), 'parent');

    }

    public function includeMeasureUnit(Activity $model)
    {
        return $this->item($model->measureUnit, new MeasureUnitTransformer(), 'parent');

    }

    public function includeTemplate(Activity $model)
    {
        return $this->item($model->template, new TemplateTransformer(), 'parent');

    }

}
