<?php

use App\Etrack\Entities\Modules\Ability;
use App\Etrack\Entities\Modules\Module;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = collect([
            [
                'data'      => [
                    'name' => 'Empresa',
                    'slug' => 'company'
                ],
                'abilities' => ['list', 'see', 'create', 'update', 'destroy']
            ]
        ]);
        $modules->each(function ($module) {
            $moduleDb = Module::where('slug', $module['data']['slug'])->first();
            if (!$moduleDb) {
                $moduleDb = Module::create($module['data']);
            }
            $abilitiesIds = Ability::whereIn('ability', $module['abilities'])->pluck('id');
            $moduleDb->abilities()->sync($abilitiesIds);
        });
    }
}
