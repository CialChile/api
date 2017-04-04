<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Activity\Program
 *
 * @property int $id
 * @property int $frequency_id
 * @property int $periodicity_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|Program whereCreatedAt($value)
 * @method static Builder|Program whereDeletedAt($value)
 * @method static Builder|Program whereFrequencyId($value)
 * @method static Builder|Program whereId($value)
 * @method static Builder|Program whereName($value)
 * @method static Builder|Program wherePeriodicityId($value)
 * @method static Builder|Program whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Activity\Frequency $frequency
 * @property-read \App\Etrack\Entities\Activity\Periodicity $periodicity
 */
class Program extends Model
{
    use SoftDeletes;

    protected $fillable = ['frequency_id', 'periodicity_id', 'name'];

    protected $dates = ['deleted_at'];

    public function frequency()
    {
        return $this->belongsTo(Frequency::class, 'frequency_id');
    }

    public function periodicity()
    {
        return $this->belongsTo(Periodicity::class, 'periodicity_id');
    }
}
