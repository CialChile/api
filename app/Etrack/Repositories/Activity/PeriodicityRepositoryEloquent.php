<?php

namespace App\Etrack\Repositories\Activity;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Activity\PeriodicityRepository;
use App\Etrack\Entities\Activity\Periodicity;
use App\Etrack\Validators\Activity\PeriodicityValidator;

/**
 * Class PeriodicityRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Activity;
 */
class PeriodicityRepositoryEloquent extends BaseRepository implements PeriodicityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Periodicity::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
