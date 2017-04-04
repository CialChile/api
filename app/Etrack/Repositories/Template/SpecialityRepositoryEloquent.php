<?php

namespace App\Etrack\Repositories\Template;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Entities\Template\Speciality;

/**
 * Class SpecialityRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Template;
 */
class SpecialityRepositoryEloquent extends BaseRepository implements SpecialityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Speciality::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
