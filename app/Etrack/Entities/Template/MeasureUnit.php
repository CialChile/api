<?php

namespace App\Etrack\Entities\Template;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Template\MeasureUnit
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|MeasureUnit whereCreatedAt($value)
 * @method static Builder|MeasureUnit whereDeletedAt($value)
 * @method static Builder|MeasureUnit whereId($value)
 * @method static Builder|MeasureUnit whereName($value)
 * @method static Builder|MeasureUnit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MeasureUnit extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

}
