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

    /**
     * Transform the \User entity
     * @param User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
