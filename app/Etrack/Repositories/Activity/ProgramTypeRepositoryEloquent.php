<?php

namespace App\Etrack\Repositories\Activity;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Activity\ProgramTypeRepository;
use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Validators\Activity\ProgramTypeValidator;

/**
 * Class ProgramTypeRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Activity;
 */
class ProgramTypeRepositoryEloquent extends BaseRepository implements ProgramTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProgramType::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
