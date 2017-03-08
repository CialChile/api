<?php

namespace App\Etrack\Repositories\Auth;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Auth\RoleRepository;
use App\Etrack\Entities\Auth\Role;
use App\Etrack\Validators\Auth\RoleValidator;

/**
 * Class RoleRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Auth;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
