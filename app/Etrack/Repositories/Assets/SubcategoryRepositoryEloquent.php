<?php

namespace App\Etrack\Repositories\Assets;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Etrack\Entities\Assets\Subcategory;

/**
 * Class SubcategoryRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Assets;
 */
class SubcategoryRepositoryEloquent extends BaseRepository implements SubcategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subcategory::class;
    }
}
