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
                    'slug' => 'admin-companies'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ],
            [
                'data'      => [
                    'name' => 'Trabajadores',
                    'slug' => 'client-rrhh-workers'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ],
            [
                'data'      => [
                    'name' => 'Roles',
                    'slug' => 'client-security-roles'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ],
            [
                'data'      => [
                    'name' => 'Usuarios',
                    'slug' => 'client-security-users'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ], [
                'data'      => [
                    'name' => 'Activos',
                    'slug' => 'client-assets'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ],
            [
                'data'      => [
                    'name' => 'Configuración Marcas',
                    'slug' => 'client-config-assets-brands'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ],
            [
                'data'      => [
                    'name' => 'Configuración Modelos',
                    'slug' => 'client-config-assets-brand-models'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ],
            [
                'data'      => [
                    'name' => 'Configuración Categoriás',
                    'slug' => 'client-config-assets-categories'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ],
            [
                'data'      => [
                    'name' => 'Configuración Subcategoriás',
                    'slug' => 'client-config-assets-subcategories'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ],
            [
                'data'      => [
                    'name' => 'Configuración Lugares de Trabajo',
                    'slug' => 'client-config-assets-workplaces'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
            ],
            [
                'data'      => [
                    'name' => 'Configuración Estados',
                    'slug' => 'client-config-status'
                ],
                'abilities' => ['list', 'show', 'store', 'update', 'destroy']
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
