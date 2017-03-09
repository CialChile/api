<?php
namespace App\Etrack\Transformers\Company;

use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\Company\Company;
use App\Etrack\Transformers\Auth\UserTransformer;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'users',
        'field',
        'user'
    ];

    public function transform(Company $model)
    {
        return [
            'id'                    => $model->id,
            'name'                  => $model->name,
            'commercial_name'       => $model->commercial_name,
            'fiscal_identification' => $model->fiscal_identification,
            'email'                 => $model->email,
            'telephone'             => $model->telephone,
            'fax'                   => $model->fax,
            'address'               => $model->address,
            'country'               => $model->country,
            'state'                 => $model->state,
            'city'                  => $model->city,
            'zip_code'              => $model->zip_code,
            'field_id'              => $model->field_id,
            'users_number'          => $model->users_number
        ];
    }

    public function includeUsers(Company $model)
    {
        return $this->collection($model->users, new UserTransformer(), 'parent');
    }

    public function includeUser(Company $model)
    {
        $user = User::where('company_id', $model->id)->where('company_admin', true)->first();
        if ($user)
            return $this->item($user, new UserTransformer(), 'parent');
    }


    public function includeField(Company $model)
    {
        return $this->item($model->field, new CompanyFieldTransformer(), 'parent');
    }
}