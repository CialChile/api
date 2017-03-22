<?php

namespace App\Etrack\Repositories\Assets;

use App\Etrack\Entities\Assets\BrandModel;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ModelRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Assets;
 */
class BrandModelRepositoryEloquent extends BaseRepository implements BrandModelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BrandModel::class;
    }

}
