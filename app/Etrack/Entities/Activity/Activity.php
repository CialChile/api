<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Template\MeasureUnit;
use App\Etrack\Entities\Template\Template;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Activity\Activity
 *
 * @property int $id
 * @property int $company_id
 * @property int $program_type_id
 * @property int $measure_unit_id
 * @property int $template_id
 * @property int $number
 * @property string $name
 * @property string $description
 * @property mixed $process_type
 * @property int $stimated_time
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property string $start_hour
 * @property string $end_hour
 * @property bool $validity
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereEndHour($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereMeasureUnitId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereProcessType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereProgramTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereStartHour($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereStimatedTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereTemplateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereValidity($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property-read \App\Etrack\Entities\Template\MeasureUnit $measureUnit
 * @property-read \App\Etrack\Entities\Activity\ProgramType $programType
 * @property-read \App\Etrack\Entities\Template\Template $template
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @property int $estimated_time
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereEstimatedTime($value)
 */
class Activity extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'program_type_id', 'measure_unit_id',
        'template_id', 'number', 'name',
        'description', 'process_type', 'estimated_time',
        'start_date', 'end_date', 'start_hour',
        'end_hour', 'validity'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'deleted_at'
    ];

    public function programType()
    {
        return $this->belongsTo(ProgramType::class, 'program_type_id');
    }

    public function measureUnit()
    {
        return $this->belongsTo(MeasureUnit::class, 'measure_unit_id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}
