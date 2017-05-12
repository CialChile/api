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
 * @property string $name
 * @property string $description
 * @property int $estimated_execution_time
 * @property bool $is_custom
 * @property array $template
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property-read \App\Etrack\Entities\Activity\ProgramType $programType
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereEstimatedExecutionTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereIsCustom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereProgramTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Template whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Template extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'program_type_id', 'is_custom',
        'name', 'estimated_execution_time', 'template', 'description'
    ];

    protected $casts = [
        'is_custom' => 'boolean',
        'template'  => 'array'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function programType()
    {
        return $this->belongsTo(ProgramType::class, 'program_type_id');
    }

}
