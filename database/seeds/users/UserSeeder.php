<?php

use App\Etrack\Entities\Auth\User;
use Illuminate\Database\Seeder;

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
                'rut_passport'  => '17259720',
                'position'      => 'Ingeniero',
                'company_admin' => false
            ],
            [
                'first_name'    => 'Javier',
                'last_name'     => 'Bastidas',
                'email'         => 'javier.bastidas@etrack.com',
                'password'      => bcrypt('password'),
                'active'        => true,
                'rut_passport'  => '17259720',
                'position'      => 'Ingeniero',
                'company_admin' => false
            ]
        ]);

        $users->each(function ($user) {
            $userDb = User::where('email', $user['email'])->first();
            if (!$userDb) {
                $userDb = new User($user);
                $userDb->save();
                if ($userDb->email == 'pedro.gorrin@etrack.com') {
                    $userDb->assignRole('administrator');
                } else {
                    $userDb->assignRole('client');
                }
            }
        });
    }
}
