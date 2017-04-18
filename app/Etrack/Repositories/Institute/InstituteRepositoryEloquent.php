<?php

namespace App\Etrack\Repositories\Institute;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Institute\InstituteRepository;
use App\Etrack\Entities\Institute\Institute;
use App\Etrack\Validators\Institute\InstituteValidator;

/**
 * Class InstituteRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Institute;
 */
class InstituteRepositoryEloquent extends BaseRepository implements InstituteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Institute::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
