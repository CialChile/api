<?php

namespace App\Etrack\Repositories\Assets;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Etrack\Entities\Assets\Asset;

/**
 * Class AssetRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Assets;
 */
class AssetRepositoryEloquent extends BaseRepository implements AssetRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Asset::class;
    }

}
