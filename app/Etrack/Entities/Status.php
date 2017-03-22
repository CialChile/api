<?php

namespace App\Etrack\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Status
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $type can refer to an asset (0) or an document (1)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|Status whereCreatedAt($value)
 * @method static Builder|Status whereDeletedAt($value)
 * @method static Builder|Status whereId($value)
 * @method static Builder|Status whereName($value)
 * @method static Builder|Status whereType($value)
 * @method static Builder|Status whereUpdatedAt($value)
 */
class Status extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'type'];
    protected $table = 'status';
    protected $casts = [
        'type' => 'integer'
    ];
    protected $dates = [
        'deleted_at'
    ];
}
