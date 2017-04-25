<?php

namespace App\Etrack\Entities\Template;

use App\Etrack\Entities\Activity\Frequency;
use App\Etrack\Entities\Activity\Periodicity;
use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Template\Template
 *
 * @property int $id
 * @property int $company_id
 * @property int $program_type_id
 * @property int $measure_unit_id
 * @property int $frequency_id
 * @property int $periodicity_id
 * @property string $name
 * @property string $description
 * @property int $estimated_execution_time
 * @property bool $is_custom
 * @property array $template
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property-read \App\Etrack\Entities\Activity\Frequency $frequency
 * @property-read \App\Etrack\Entities\Template\MeasureUnit $measureUnit
 * @property-read \App\Etrack\Entities\Activity\Periodicity $periodicity
 * @property-read \App\Etrack\Entities\Activity\ProgramType $programType
 * @method static Builder|BaseModel inCompany()
 * @method static Builder|Template whereCompanyId($value)
 * @method static Builder|Template whereCreatedAt($value)
 * @method static Builder|Template whereDeletedAt($value)
 * @method static Builder|Template whereDescription($value)
 * @method static Builder|Template whereEstimatedExecutionTime($value)
 * @method static Builder|Template whereFrequencyId($value)
 * @method static Builder|Template whereId($value)
 * @method static Builder|Template whereIsCustom($value)
 * @method static Builder|Template whereMeasureUnitId($value)
 * @method static Builder|Template whereName($value)
 * @method static Builder|Template wherePeriodicityId($value)
 * @method static Builder|Template whereProgramTypeId($value)
 * @method static Builder|Template whereTemplate($value)
 * @method static Builder|Template whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Template extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'program_type_id', 'is_custom',
        'measure_unit_id', 'frequency_id', 'periodicity_id',
        'name', 'estimated_execution_time', 'template', 'description'
    ];

    protected $casts = [
        'is_custom' => 'boolean',
        'template'  => 'array'
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

}
