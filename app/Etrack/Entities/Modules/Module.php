<?php

namespace App\Etrack\Entities\Modules;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Etrack\Entities\Modules\Module
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Modules\Ability[] $abilities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Modules\Module[] $relatedModules
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Modules\Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Modules\Module whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Modules\Module whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Modules\Module whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Modules\Module whereUpdatedAt($value)
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
        return $this->belongsToMany(Module::class, 'modules_relations', 'related_module_id', 'module_id');
    }
}
