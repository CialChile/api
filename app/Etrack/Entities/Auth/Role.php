<?php

namespace App\Etrack\Entities\Auth;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use \Kodeine\Acl\Models\Eloquent\Role as KodeineRole;

/**
 * App\Etrack\Entities\Auth\Role
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Kodeine\Acl\Models\Eloquent\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Auth\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\Role whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\Role whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends KodeineRole
{
    protected $fillable = ['company_id', 'name', 'slug', 'description'];

}
