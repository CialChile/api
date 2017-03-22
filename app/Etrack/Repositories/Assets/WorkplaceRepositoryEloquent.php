<?php

namespace App\Etrack\Repositories\Assets;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Etrack\Entities\Assets\Workplace;

/**
 * Class WorkplaceRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Assets;
 */
class WorkplaceRepositoryEloquent extends BaseRepository implements WorkplaceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Workplace::class;
    }
}
