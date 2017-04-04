<?php

namespace App\Etrack\Repositories\Activity;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Activity\FrequencyRepository;
use App\Etrack\Entities\Activity\Frequency;
use App\Etrack\Validators\Activity\FrequencyValidator;

/**
 * Class FrequencyRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Activity;
 */
class FrequencyRepositoryEloquent extends BaseRepository implements FrequencyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Frequency::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
