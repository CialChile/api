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
        return $resultPermissions->toArray();
    }
}
