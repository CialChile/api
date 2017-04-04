<?php

namespace App\Etrack\Repositories\Activity;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Activity\ProgramRepository;
use App\Etrack\Entities\Activity\Program;
use App\Etrack\Validators\Activity\ProgramValidator;

/**
 * Class ProgramRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Activity;
 */
class ProgramRepositoryEloquent extends BaseRepository implements ProgramRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Program::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
