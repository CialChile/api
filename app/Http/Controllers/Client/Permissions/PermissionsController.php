<?php
namespace App\Http\Controllers\Client\Permissions;

use App\Etrack\Entities\Modules\Ability;
use App\Etrack\Entities\Modules\Module;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    public function index()
    {
        $modules = Module::with(['abilities'])->where('slug','like','client%')->get();

        $modules = $modules->map(function (Module $module) {
            $abilities = [];
            $module->abilities->each(function (Ability $ability) use (&$abilities) {
                $abilities[$ability->ability] = true;
            });
            $module->abilitiesList = $abilities;
            unset($module->abilities);
            return $module;
        });

        return response()->json($modules);
    }
}