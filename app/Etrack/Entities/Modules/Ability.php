<?php

namespace App\Etrack\Entities\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Modules\Ability
 *
 * @property int $id
 * @property string $ability
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Modules\Module[] $modules
 * @method static Builder|Ability whereAbility($value)
 * @method static Builder|Ability whereId($value)
 * @mixin \Eloquent
 */
class Ability extends Model
{

    protected $fillable = ['ability'];

    public $timestamps = false;

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'modules_abilities', 'module_id', 'ability_id');
    }
}
