<?php

namespace App\Etrack\Entities\Template;

use App\Etrack\Entities\Activity\Frequency;
use App\Etrack\Entities\Activity\Periodicity;
use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Template\Template
 *
 * @property int $id
 * @property int $company_id
 * @property int $template_type_id
 * @property int $program_type_id
 * @property int $measure_unit_id
 * @property int $frequency_id
 * @property int $periodicity_id
 * @property string $name_template
 * @property string $name_activity
 * @property string $description_activity
 * @property int $execution_stimated_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereDescriptionActivity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereExecutionStimatedTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereFrequencyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereMeasureUnitId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereNameActivity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereNameTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template wherePeriodicityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereProgramTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereTemplateTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property-read \App\Etrack\Entities\Activity\Frequency $frequency
 * @property-read \App\Etrack\Entities\Template\MeasureUnit $measureUnit
 * @property-read \App\Etrack\Entities\Activity\Periodicity $periodicity
 * @property-read \App\Etrack\Entities\Activity\ProgramType $programType
 * @property-read \App\Etrack\Entities\Template\TemplateType $templateType
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @property int $execution_estimated_time
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereExecutionEstimatedTime($value)
 */
class Template extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'template_type_id', 'program_type_id',
        'measure_unit_id', 'frequency_id', 'periodicity_id',
        'name_template', 'name_activity', 'description_activity',
        'execution_estimated_time'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function frequency()
    {
        return $this->belongsTo(Frequency::class, 'frequency_id');
    }

    public function periodicity()
    {
        return $this->belongsTo(Periodicity::class, 'periodicity_id');
    }

    public function programType()
    {
        return $this->belongsTo(ProgramType::class, 'program_type_id');
    }

    public function measureUnit()
    {
        return $this->belongsTo(MeasureUnit::class, 'measure_unit_id');
    }

    public function templateType()
    {
        return $this->belongsTo(TemplateType::class, 'template_type_id');
    }

}
