<?php

namespace App\Etrack\Repositories\Auth;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Auth\UserRepository;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Validators\Auth\UserValidator;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Auth;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
