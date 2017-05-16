<?php

namespace App\Etrack\Entities\Activity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $severity
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Activity\ActivityScheduleExecution[] $activityScheduleExecutions
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus whereSeverity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityScheduleExecutionStatus extends Model
{
    protected $table = 'activity_schedule_execution_status';

    protected $fillable = ['name', 'slug', 'severity'];

    public function activityScheduleExecutions()
    {
        return $this->hasMany(ActivityScheduleExecution::class, 'status_id');
    }
}
