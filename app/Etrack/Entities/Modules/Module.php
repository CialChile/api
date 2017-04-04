<?php

namespace App\Etrack\Entities\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Modules\Module
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Modules\Ability[] $abilities
 * @property-read \Illuminate\Database\Eloquent\Collection|Module[] $relatedModules
 * @method static Builder|Module whereCreatedAt($value)
 * @method static Builder|Module whereId($value)
 * @method static Builder|Module whereName($value)
 * @method static Builder|Module whereSlug($value)
 * @method static Builder|Module whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Module extends Model
{
    protected $fillable = ['name', 'slug'];

    public function abilities()
    {
        return $this->belongsToMany(Ability::class, 'modules_abilities', 'module_id', 'ability_id');
    }

    public function relatedModules()
    {
        return $this->belongsToMany(Module::class, 'modules_relations', 'module_id','related_module_id');
    }
}
