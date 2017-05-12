<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Template\Template;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Activity\Activity
 *
 * @property int $id
 * @property int $company_id
 * @property int $supervisor_id
 * @property int $program_type_id
 * @property int $template_id
 * @property string $name
 * @property string $description
 * @property int $estimated_time
 * @property bool $estimated_time_unit
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property-read \App\Etrack\Entities\Activity\ProgramType $programType
 * @property-read \App\Etrack\Entities\Auth\User $supervisor
 * @property-read \App\Etrack\Entities\Template\Template $template
 * @method static Builder|BaseModel inCompany()
 * @method static Builder|Activity whereCompanyId($value)
 * @method static Builder|Activity whereCreatedAt($value)
 * @method static Builder|Activity whereDeletedAt($value)
 * @method static Builder|Activity whereDescription($value)
 * @method static Builder|Activity whereEstimatedTime($value)
 * @method static Builder|Activity whereEstimatedTimeUnit($value)
 * @method static Builder|Activity whereId($value)
 * @method static Builder|Activity whereName($value)
 * @method static Builder|Activity whereProgramTypeId($value)
 * @method static Builder|Activity whereSupervisorId($value)
 * @method static Builder|Activity whereTemplateId($value)
 * @method static Builder|Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Activity\ActivityMaterial[] $materials
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Activity\ActivityProcedure[] $procedures
 * @property int $creator_id
 * @property-read \App\Etrack\Entities\Auth\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Activity\ActivityObservation[] $observations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Activity\ActivitySchedule[] $schedules
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Activity whereCreatorId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Assets\Asset[] $assets
 */
class Activity extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'program_type_id', 'creator_id',
        'template_id', 'supervisor_id', 'name',
        'description', 'estimated_time', 'estimated_time_unit'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function programType()
    {
        return $this->belongsTo(ProgramType::class, 'program_type_id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function materials()
    {
        return $this->hasMany(ActivityMaterial::class);
    }

    public function procedures()
    {
        return $this->hasMany(ActivityProcedure::class);
    }

    public function schedules()
    {
        return $this->hasMany(ActivitySchedule::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'activity_assets');
    }

    public function observations()
    {
        return $this->hasMany(ActivityObservation::class);
    }
}
