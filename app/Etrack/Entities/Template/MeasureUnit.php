<?php

namespace App\Etrack\Entities\Template;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Template\MeasureUnit
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\MeasureUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\MeasureUnit whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\MeasureUnit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\MeasureUnit whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\MeasureUnit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MeasureUnit extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

}
