<?php

namespace App\Etrack\Entities\Activity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Etrack\Entities\Activity\ActivityObservation
 *
 * @property int $id
 * @property int $activity_id
 * @property string $observation
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Etrack\Entities\Activity\Activity $activity
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityObservation whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityObservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityObservation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityObservation whereObservation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityObservation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityObservation extends Model
{
    protected $fillable = ['activity_id', 'observation'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
