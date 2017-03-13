<?php

namespace App\Etrack\Repositories\Worker;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Worker\WorkerRepository;
use App\Etrack\Entities\Worker\Worker;
use App\Etrack\Validators\Worker\WorkerValidator;

/**
 * Class WorkerRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Worker;
 */
class WorkerRepositoryEloquent extends BaseRepository implements WorkerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Worker::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
