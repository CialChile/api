<?php

namespace App\Etrack\Entities\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;


/**
 * App\Etrack\Entities\Activity\ProgramType
 *
 * @property int $id
 * @property string $name
 * @property bool $is_inspection
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|ProgramType whereCreatedAt($value)
 * @method static Builder|ProgramType whereDeletedAt($value)
 * @method static Builder|ProgramType whereId($value)
 * @method static Builder|ProgramType whereIsInspection($value)
 * @method static Builder|ProgramType whereName($value)
 * @method static Builder|ProgramType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProgramType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'is_inspection'];
    protected $casts = [
        'is_inspection' => 'boolean'
    ];
    protected $dates = ['deleted_at'];

}
