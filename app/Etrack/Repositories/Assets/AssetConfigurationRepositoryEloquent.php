<?php

namespace App\Etrack\Repositories\Assets;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Assets\AssetConfigurationRepository;
use App\Etrack\Entities\Assets\AssetConfiguration;
use App\Etrack\Validators\Assets\AssetConfigurationValidator;

/**
 * Class AssetConfigurationRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Assets;
 */
class AssetConfigurationRepositoryEloquent extends BaseRepository implements AssetConfigurationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AssetConfiguration::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
