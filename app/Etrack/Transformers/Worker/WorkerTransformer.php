<?php
namespace App\Etrack\Transformers\Worker;

use App\Etrack\Entities\Worker\Worker;
use App\Etrack\Transformers\Auth\UserTransformer;
use League\Fractal\TransformerAbstract;

class WorkerTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'user'
    ];

    public function transform(Worker $model)
    {
        return [
            'id'                  => $model->id,
            'first_name'          => $model->first_name,
            'last_name'           => $model->last_name,
            'email'               => $model->email,
            'birthday'            => $model->birthday ? $model->birthday->toDateString() : null,
            'rut_passport'        => $model->rut_passport,
            'position'            => $model->position,
            'address'             => $model->address,
            'country'             => $model->country,
            'state'               => $model->state,
            'city'                => $model->city,
            'zip_code'            => $model->zip_code,
            'telephone'           => $model->telephone,
            'emergency_telephone' => $model->emergency_telephone,
            'emergency_contact'   => $model->emergency_contact,
            'medical_information' => $model->medical_information,
            'active'              => $model->active
        ];
    }

    public function includeUser(Worker $model)
    {
        $user = $model->user;
        if ($user) {
            return $this->item($user, new UserTransformer(), 'parent');
        }
    }

}