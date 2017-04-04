<?php

namespace App\Etrack\Repositories\Template;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Template\PositionRepository;
use App\Etrack\Entities\Template\Position;
use App\Etrack\Validators\Template\PositionValidator;

/**
 * Class PositionRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Template;
 */
class PositionRepositoryEloquent extends BaseRepository implements PositionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Position::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
