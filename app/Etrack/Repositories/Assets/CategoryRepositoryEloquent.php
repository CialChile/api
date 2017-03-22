<?php

namespace App\Etrack\Repositories\Assets;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Etrack\Entities\Assets\Category;

/**
 * Class CategoryRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Assets;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }
}
