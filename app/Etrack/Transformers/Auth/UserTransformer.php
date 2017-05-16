<?php

namespace App\Etrack\Transformers\Auth;

use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Auth\User;

/**
 * Class UserTransformer
 * @package namespace App\Etrack\Transformers\Auth;
 */
class UserTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'role',
        'permissions'
    ];

    /**
     * Transform the \User entity
     * @param User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        $profilePicture = $model->getFirstMediaUrl('profile', 'normal');
        $profilePictureThumb = $model->getFirstMediaUrl('profile', 'thumbnail');

        return [
            'id'              => (int)$model->id,
            'first_name'      => $model->first_name,
            'last_name'       => $model->last_name,
            'full_name'       => $model->first_name . ' ' . $model->last_name,
            'email'           => $model->email,
            'isSuperUser'     => $model->isSuperUser(),
            'active'          => $model->active,
            'company_admin'   => $model->company_admin,
            'image'           => $profilePicture ? env('APP_URL') . $profilePicture : null,
            'thumb'           => $profilePictureThumb ? env('APP_URL') . $profilePictureThumb : null,
            'timezone'        => $model->timezone,
            'image_formatted' => [
                'thumbnail'  => $profilePictureThumb ? env('APP_URL') . $profilePictureThumb : env('APP_URL') . '/images/missing/worker/missing2.png',
                'source'     => $profilePicture ? env('APP_URL') . $profilePicture : env('APP_URL') . '/images/missing/worker/missing2.png',
                'title'      => $model->first_name . ' ' . $model->last_name,
                'notDefault' => $profilePictureThumb ? true : false
            ],
        ];
    }

    /**
     * Transform the Role entity of an user
     * @param User $model
     * @return \League\Fractal\Resource\Item
     */
    public function includeRole(User $model)
    {
        return $this->item($model->roles->first(), new RoleTransformer(), 'parent');
    }

    /**
     * get the users permissions
     * @param User $model
     * @return \League\Fractal\Resource\Item
     */
    public function includePermissions(User $model)
    {
        return $this->item($model->getPermissions(), new PermissionsTransformer(), 'parent');
    }
}

