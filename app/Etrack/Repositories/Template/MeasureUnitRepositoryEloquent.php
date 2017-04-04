<?php

namespace App\Etrack\Repositories\Template;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Entities\Template\MeasureUnit;

/**
 * Class MeasureUnitRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Template;
 */
class MeasureUnitRepositoryEloquent extends BaseRepository implements MeasureUnitRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MeasureUnit::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
