<?php

namespace App\Etrack\Entities\Auth;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
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
 * @method static Builder|Role whereCompanyId($value)
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereSlug($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static Builder|Role company()
 * @method static Builder|Role inCompany()
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|Role whereDeletedAt($value)
 */
class Role extends KodeineRole
{
    use SoftDeletes;
    protected $fillable = ['company_id', 'name', 'slug', 'description'];
    protected $dates = ['deleted_at'];

    public function scopeInCompany($query)
    {
        $company_id = \Auth::user()->company_id;
        /** @var Builder $query */
        return $query->where('company_id', $company_id);
    }
}
