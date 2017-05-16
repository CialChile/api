<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\Auth\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Etrack\Entities\Activity\ActivityScheduleExecution
 *
 * @property int $id
 * @property int $executed_by
 * @property int $activity_schedule_id
 * @property int $status_id
 * @property \Carbon\Carbon $execution_date
 * @property \Carbon\Carbon $executed_date
 * @property int $duration
 * @property bool $duration_unit 0: hours, 1:days, 2:weeks, 3:months
 * @property bool $executed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Etrack\Entities\Activity\ActivitySchedule $activitySchedule
 * @property-read \App\Etrack\Entities\Auth\User $executedBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Activity\ActivityScheduleExecutionObservation[] $observations
 * @property-read \App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus $status
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereActivityScheduleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereDurationUnit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereExecuted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereExecutedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereExecutedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereExecutionDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecution whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityScheduleExecution extends Model
{
    protected $table = 'activity_schedule_executions';

    protected $fillable = [
        'activity_schedule_id', 'status_id', 'executed_by', 'execution_date',
        'executed_date', 'duration', 'duration_unit', 'executed'
    ];

    protected $dates = ['executed_date', 'execution_date'];
    protected $casts = [
        'executed'             => 'boolean',
        'activity_schedule_id' => 'integer',
        'status_id'            => 'integer',
        'executed_by'          => 'integer',
    ];

    public function activitySchedule()
    {
        return $this->belongsTo(ActivitySchedule::class);
    }

    public function status()
    {
        return $this->belongsTo(ActivityScheduleExecutionStatus::class, 'status_id');
    }

    public function executedBy()
    {
        return $this->belongsTo(User::class, 'executed_by');
    }

    public function observations()
    {
        return $this->hasMany(ActivityScheduleExecutionObservation::class, 'activity_schedule_execution_id');
    }
}
