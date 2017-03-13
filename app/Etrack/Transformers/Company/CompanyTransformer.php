<?php
namespace App\Etrack\Transformers\Company;

use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\Company\Company;
use App\Etrack\Transformers\Auth\UserTransformer;
use App\Etrack\Transformers\Worker\WorkerTransformer;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'users',
        'field',
        'responsible',
        'workers'
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
            'users_number'          => $model->users_number,
            'active'                => $model->active
        ];
    }

    public function includeUsers(Company $model)
    {
        return $this->collection($model->users, new UserTransformer(), 'parent');
    }

    public function includeWorkers(Company $model)
    {
        if ($model->workers)
            return $this->collection($model->workers, new WorkerTransformer(), 'parent');
    }


    public function includeResponsible(Company $model)
    {
        $user = User::with('worker')->where('company_id', $model->id)->where('company_admin', true)->first();
        if ($user->worker)
            return $this->item($user->worker, new WorkerTransformer(), 'parent');
    }


    public function includeField(Company $model)
    {
        return $this->item($model->field, new CompanyFieldTransformer(), 'parent');
    }
}