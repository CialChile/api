<?php

namespace App\Etrack\Entities\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Activity\ActivityMaterial
 *
 * @property int $id
 * @property int $activity_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Etrack\Entities\Activity\Activity $activity
 * @method static Builder|ActivityMaterial whereActivityId($value)
 * @method static Builder|ActivityMaterial whereCreatedAt($value)
 * @method static Builder|ActivityMaterial whereId($value)
 * @method static Builder|ActivityMaterial whereName($value)
 * @method static Builder|ActivityMaterial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityMaterial extends Model
{
    protected $table = 'activity_materials';
    protected $fillable = ['activity_id', 'name'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
