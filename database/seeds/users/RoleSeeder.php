<?php

use App\Etrack\Entities\Auth\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = collect([
            [
                'company_id'  => 0,
                'name'        => 'Administrator',
                'slug'        => 'admin-administrator',
                'description' => 'Maneja los privilegios de administracion'
            ]
        ]);

        $roles->each(function ($role) {
            $roleDb = Role::where('slug', $role['slug'])->where('company_id', $role['company_id'])->first();
            if (!$roleDb) {
                $roleDb = new Role($role);
                $roleDb->save();
            }
        });
    }
}
