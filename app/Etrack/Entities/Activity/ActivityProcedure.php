<?php

namespace App\Etrack\Entities\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Activity\ActivityProcedure
 *
 * @property int $id
 * @property int $activity_id
 * @property string $name
 * @property array $definition
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Etrack\Entities\Activity\Activity $activity
 * @method static Builder|ActivityProcedure whereActivityId($value)
 * @method static Builder|ActivityProcedure whereCreatedAt($value)
 * @method static Builder|ActivityProcedure whereDefinition($value)
 * @method static Builder|ActivityProcedure whereId($value)
 * @method static Builder|ActivityProcedure whereName($value)
 * @method static Builder|ActivityProcedure whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $type
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ActivityProcedure whereType($value)
 */
class ActivityProcedure extends Model
{
    protected $table = 'activity_procedures';
    protected $fillable = ['activity_id', 'type', 'name', 'definition'];

    protected $casts = [
        'definition' => 'array'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
