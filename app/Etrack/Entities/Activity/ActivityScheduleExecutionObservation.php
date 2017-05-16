<?php

namespace App\Etrack\Entities\Activity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Etrack\Entities\Activity\ActivityScheduleExecutionObservation
 *
 * @property int $id
 * @property int $activity_schedule_execution_id
 * @property string $observation
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Etrack\Entities\Activity\ActivityScheduleExecution $activityScheduleExecution
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionObservation whereActivityScheduleExecutionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionObservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionObservation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionObservation whereObservation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityScheduleExecutionObservation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityScheduleExecutionObservation extends Model
{
    protected $table = 'activity_schedule_execution_observations';

    protected $fillable = ['activity_schedule_execution_id', 'observation'];

    protected $casts = [
        'activity_schedule_execution_id' => 'integer'
    ];

    public function activityScheduleExecution()
    {
        return $this->belongsTo(ActivityScheduleExecution::class, 'activity_schedule_execution_id');
    }
}
