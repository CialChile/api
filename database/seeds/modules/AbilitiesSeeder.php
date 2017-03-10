<?php

use App\Etrack\Entities\Modules\Ability;
use Illuminate\Database\Seeder;

class AbilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = collect(['list', 'show', 'store', 'update', 'destroy']);
        $abilities->each(function ($ability) {
            $abilityDd = Ability::where('ability', $ability)->first();
            if (!$abilityDd) {
                Ability::create(['ability' => $ability]);
            }
        });
    }
}
