<?php

use App\Etrack\Entities\Modules\Ability;
use App\Etrack\Entities\Modules\Module;
use Illuminate\Database\Seeder;

class ModulesRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assetsModule = Module::where('slug', 'client-assets')->first();
        $modules = Module::where('slug', 'like', 'client-config-assets%')
            ->orWhere('slug', 'client-config-status')->pluck('id');
        $assetsModule->relatedModules()->sync($modules->toArray());
    }
}
