<?php

namespace App\Etrack\Repositories\Assets;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Etrack\Entities\Assets\Brand;

/**
 * Class BrandRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Assets;
 */
class BrandRepositoryEloquent extends BaseRepository implements BrandRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Brand::class;
    }

}
