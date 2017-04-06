<?php

use App\Etrack\Entities\Auth\Role;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\Modules\Ability;
use App\Etrack\Entities\Modules\Module;
use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect([
            [
                'company_id'    => null,
                'first_name'    => 'Pedro',
                'last_name'     => 'Gorrin',
                'email'         => 'pedro.gorrin@etrack.com',
                'password'      => bcrypt('password'),
                'active'        => true,
                // 'rut_passport'  => '17259720',
                //  'position'      => 'Ingeniero',
                'company_admin' => false,
                'worker_id'     => '1'
            ],
            [
                'first_name'    => 'Javier',
                'last_name'     => 'Bastidas',
                'email'         => 'javier.bastidas@etrack.com',
                'password'      => bcrypt('password'),
                'active'        => true,
                // 'rut_passport'  => '17259720',
                // 'position'      => 'Ingeniero',
                'company_admin' => false,
                'worker_id'     => '1'

            ]
        ]);

        $users->each(function ($user) {
            $userDb = User::where('email', $user['email'])->first();
            if (!$userDb) {
                $userDb = new User($user);
                $userDb->save();
                $userDb->assignRole('admin-administrator');
                $this->rolePermissions();
            } else {
                /** @var User $userDb */
                if ($userDb->hasRole('admin-administrator')) {
                    $this->rolePermissions();
                }
            }
        });
    }

    private function rolePermissions()
    {
        $role = Role::where('slug', 'admin-administrator')->where('company_id', 0)->first();
        $adminModules = Module::where('slug', 'like', 'admin-%')->with('abilities')->get();
        $adminModules->each(function (Module $module) use ($role) {
            $permissions = [];
            $module->abilities->each(function (Ability $ability) use (&$permissions) {
                $permissions[$ability->ability] = true;
            });

            $permission = Permission::where('name', $module->slug)->first();
            if (!$permission) {
                $permission = new Permission();
                $permissionsRole = $permission->create([
                    'name'        => $module->slug,
                    'slug'        => $permissions,
                    'description' => 'Maneja los permisos del modulo ' . $module->name
                ]);
                $role->assignPermission($permissionsRole);
            }
        });

    }
}
