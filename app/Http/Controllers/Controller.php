<?php

namespace App\Http\Controllers;

use App\Etrack\Entities\Modules\Module;
use App\Exceptions\Permissions\PermissionException;
use Dingo\Api\Routing\Helpers;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;

    public $module;

    public function userCan($permissions, $module = null)
    {
        if (!$this->module) {
            throw new Exception('Debe establecer la variable module en el controlador');
        }

        if (!str_contains($this->module, 'especial')) {
            $module = Module::with('relatedModules')->where('slug', $this->module)->first();

            $relatedModules = $module->relatedModules;
            $relatedModules->each(function ($relatedModule) use (&$permissions) {
                if (is_array($permissions)) {
                    array_push($permissions, 'see.' . $relatedModule->slug);
                } else {
                    $permissions .= '|see.' . $relatedModule->slug;
                }
            });
        }

        $permissionsString = '';
        if (!is_array($permissions)) {
            $permissions = explode('|', $permissions);
        }
        foreach ($permissions as $permission) {
            $permissionsString = $this->formatPermissionAsString($module, $permission, $permissionsString);
        }

        if (!$this->loggedInUser()->can($permissionsString)) {
            $permissions = explode('|', $permissionsString);

            foreach ($permissions as $permission) {
                $permissionMod = explode('.', $permission);
                $mod = array_key_exists(1, $permissionMod) ? $permissionMod[1] : $this->module;
                $module = Module::where('slug', $mod)->first();
                throw new PermissionException('No tiene permisos para ' . $permissionMod[0] . ' ' . $module->name);

            }
        }
    }

    private function formatPermissionAsString($module, $permission, $permissionsString)
    {
        if (strpos($permission, '.') === false) {
            $mod = $module ? $module->slug : $this->module;
            $perm = $permission . '.' . $mod;
            $permissionsString .= strlen($permissionsString) ? '|' . $perm : $perm;
            return $permissionsString;
        } else {
            $permissionsString .= strlen($permissionsString) ? '|' . $permission : $permission;
            return $permissionsString;
        }
    }

    public function loggedInUser()
    {
        return \Auth::user();
    }

}
