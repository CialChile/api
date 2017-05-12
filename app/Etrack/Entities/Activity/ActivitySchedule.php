<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Entities\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;


/**
 * App\Etrack\Entities\Activity\ActivitySchedule
 *
 * @property int $id
 * @property int $creator_id
 * @property int $activity_id
 * @property int $operator_id
 * @property int $asset_id
 * @property string $program_type_slug
 * @property string $frequency
 * @property int $periodicity
 * @property array $config
 * @property array $days
 * @property int $day_of_month
 * @property string $start_time
 * @property int $estimated_duration
 * @property bool $estimated_duration_unit 0: hours, 1:days, 2:weeks, 3:months
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Etrack\Entities\Activity\Activity $activity
 * @property-read \App\Etrack\Entities\Assets\Asset $asset
 * @property-read \App\Etrack\Entities\Auth\User $createdBy
 * @property-read \App\Etrack\Entities\Auth\User $operator
 * @method static Builder|ActivitySchedule whereActivityId($value)
 * @method static Builder|ActivitySchedule whereAssetId($value)
 * @method static Builder|ActivitySchedule whereConfig($value)
 * @method static Builder|ActivitySchedule whereCreatedAt($value)
 * @method static Builder|ActivitySchedule whereCreatorId($value)
 * @method static Builder|ActivitySchedule whereDayOfMonth($value)
 * @method static Builder|ActivitySchedule whereDays($value)
 * @method static Builder|ActivitySchedule whereDeletedAt($value)
 * @method static Builder|ActivitySchedule whereEstimatedDuration($value)
 * @method static Builder|ActivitySchedule whereEstimatedDurationUnit($value)
 * @method static Builder|ActivitySchedule whereFrequency($value)
 * @method static Builder|ActivitySchedule whereId($value)
 * @method static Builder|ActivitySchedule whereOperatorId($value)
 * @method static Builder|ActivitySchedule wherePeriodicity($value)
 * @method static Builder|ActivitySchedule whereProgramTypeSlug($value)
 * @method static Builder|ActivitySchedule whereStartTime($value)
 * @method static Builder|ActivitySchedule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivitySchedule extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'creator_id', 'activity_id', 'operator_id', 'asset_id',
        'program_type_slug', 'frequency', 'periodicity', 'config',
        'days', 'day_of_month', 'start_time', 'estimated_duration',
        'estimated_duration_unit'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'creator_id'  => 'integer',
        'asset_id'    => 'integer',
        'activity_id' => 'integer',
        'operator_id' => 'integer',
        'config'      => 'array',
        'days'        => 'array',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
