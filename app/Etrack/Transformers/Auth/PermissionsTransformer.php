<?php

namespace App\Etrack\Transformers\Auth;

use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Auth\Permissions;

/**
 * Class PermissionsTransformer
 * @package namespace App\Etrack\Transformers\Auth;
 */
class PermissionsTransformer extends TransformerAbstract
{

    /**
     * Transform the user permissions
     * @param array $userPermissions
     * @return array
     */
    public function transform($userPermissions = [])
    {
        $resultPermissions = collect();
        foreach ($userPermissions as $module => $permissions) {
            foreach ($permissions as $permission => $value) {
                if ($value)
                    $resultPermissions->push($module . '.' . $permission);
            }
        }
        if ($resultPermissions->contains(function ($value, $key) {
            return str_contains($value, 'client-rrhh');
        })
        ) {
            $resultPermissions->push('client-rrhh');
        }
        if ($resultPermissions->contains(function ($value, $key) {
            return str_contains($value, 'client-config-assets') || str_contains($value, 'client-assets');
        })
        ) {
            $resultPermissions->push('client-assets');
        }

        if ($resultPermissions->contains(function ($value, $key) {
            return str_contains($value, 'client-config');
        })
        ) {
            $resultPermissions->push('client-configuration');
        }

        if ($resultPermissions->contains(function ($value, $key) {
            return str_contains($value, 'client-certifications');
        })
        ) {
            $resultPermissions->push('client-certifications');
        }

        if ($resultPermissions->contains(function ($value, $key) {
            return str_contains($value, 'client-activities');
        })
        ) {
            $resultPermissions->push('client-activities');
        }


        if ($resultPermissions->contains(function ($value, $key) {
            return str_contains($value, 'client-security');
        })
        ) {
            $resultPermissions->push('client-security');
        }

        if ($resultPermissions->contains(function ($value, $key) {
            return str_contains($value, 'admin-configuration');
        })
        ) {
            $resultPermissions->push('admin-configuration');
        }

        if ($resultPermissions->contains(function ($value, $key) {
            return str_contains($value, 'admin-templates') || str_contains($value, 'admin-program-types');
        })
        ) {
            $resultPermissions->push('admin-activities');
        }

        if ($resultPermissions->contains(function ($value, $key) {
            return str_contains($value, 'admin-security');
        })
        ) {
            $resultPermissions->push('admin-security');
        }
        return $resultPermissions->toArray();
    }
}
