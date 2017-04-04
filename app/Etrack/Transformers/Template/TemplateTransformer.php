<?php

namespace App\Etrack\Transformers\Template;

use App\Etrack\Transformers\Activity\FrequencyTransformer;
use App\Etrack\Transformers\Activity\PeriodicityTransformer;
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
        'template_type',
        'program_type',
        'measure_unit',
        'frequency',
        'periodicity'
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
            'template_type_id'         => $model->template_type_id,
            'program_type_id'          => $model->program_type_id,
            'measure_unit_id'          => $model->measure_unit_id,
            'frequency_id'             => $model->frequency_id,
            'periodicity_id'           => $model->periodicity_id,
            'name_template'            => $model->name_template,
            'name_activity'            => $model->name_activity,
            'description_activity'     => $model->description_activity,
            'execution_estimated_time' => $model->execution_estimated_time,
            'created_at'               => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at'               => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }

    public function includeCompany(Template $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeTemplateType(Template $model)
    {
        return $this->item($model->templateType, new TemplateTypeTransformer(), 'parent');
    }

    public function includeProgramType(Template $model)
    {
        return $this->item($model->programType, new ProgramTypeTransformer(), 'parent');
    }

    public function includeMeasureUnit(Template $model)
    {
        return $this->item($model->measureUnit, new MeasureUnitTransformer(), 'parent');
    }

    public function includeFrequency(Template $model)
    {
        return $this->item($model->frequency, new FrequencyTransformer(), 'parent');
    }

    public function includePeriodicity(Template $model)
    {
        return $this->item($model->periodicity, new PeriodicityTransformer(), 'parent');
    }
}