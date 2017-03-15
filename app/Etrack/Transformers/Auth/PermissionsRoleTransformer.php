<?php

namespace App\Etrack\Transformers\Auth;

use App\Etrack\Entities\Modules\Module;
use Kodeine\Acl\Models\Eloquent\Permission;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Auth\Permissions;

/**
 * Class PermissionsTransformer
 * @package namespace App\Etrack\Transformers\Auth;
 */
class PermissionsRoleTransformer extends TransformerAbstract
{

    /**
     * Transform the user permissions
     * @param Permission $model
     * @return array
     */
    public function transform(Permission $model)
    {

        $module = Module::where('slug', $model->name)->first();
        $permissions = [
            'id'   => $model->id,
            'name' => $module->name,
            'slug' => $model->name,
        ];

        return array_merge($permissions, $model->slug);
    }
}
