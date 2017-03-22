<?php

namespace App\Etrack\Entities\Assets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Assets\Brand
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereDeletedAt($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereName($value)
 * @method static Builder|Brand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Brand extends Model
{
    use SoftDeletes;
    protected $fillable = ['name'];

    protected $dates = [
        'deleted_at'
    ];

}
