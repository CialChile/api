<?php

namespace App\Etrack\Transformers\Auth;

use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Auth\Role;

/**
 * Class RoleTransformer
 * @package namespace App\Etrack\Transformers\Auth;
 */
class RoleTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'permissions'
    ];

    /**
     * Transform the \Role entity
     * @param Role $model
     * @return array
     */
    public function transform(Role $model)
    {
        return [
            'id'          => (int)$model->id,
            'name'        => $model->name,
            'slug'        => $model->slug,
            'description' => $model->description,
        ];
    }

    public function includePermissions(Role $model)
    {
        $permissions = $model->permissions;
        return $this->collection($permissions,new PermissionsRoleTransformer(),'parent');
    }
}
