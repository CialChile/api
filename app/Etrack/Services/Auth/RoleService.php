<?php
namespace App\Etrack\Services\Auth;

use App\Etrack\Entities\Auth\Role;
use App\Etrack\Entities\Modules\Ability;
use App\Etrack\Entities\Modules\Module;
use Kodeine\Acl\Models\Eloquent\Permission;

class RoleService
{

    public function addFullPermissionToRole(Role $role)
    {
        $clientModules = Module::where('slug', 'like', 'client.%')->with('abilities')->get();
        $clientModules->each(function (Module $module) use ($role) {
            $permissions = [];
            $module->abilities->each(function (Ability $ability) use (&$permissions) {
                $permissions[$ability->ability] = true;
            });

            $permission = new Permission();
            $permUser = $permission->create([
                'name'        => $module->slug,
                'slug'        => $permissions,
                'description' => 'Maneja los permisos del modulo ' . $module->name
            ]);
            $role->assignPermission($permUser);
        });
    }
}