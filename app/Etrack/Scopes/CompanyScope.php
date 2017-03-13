<?php
namespace App\Etrack\Scopes;

use App\Etrack\Entities\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use League\Flysystem\Exception;

class CompanyScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return Builder
     * @throws Exception
     */
    public function apply(Builder $builder, Model $model)
    {
        /** @var User $user */
        $user = \JWTAuth::parseToken()->authenticate();
        if ($user) {
            return $builder->where('company_id', $user->company_id);
        }

        throw new Exception('unauthenticated');
    }
}