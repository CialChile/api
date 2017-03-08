<?php

namespace App\Etrack\Repositories\Modules;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Modules\AbilityRepository;
use App\Etrack\Entities\Modules\Ability;
use App\Etrack\Validators\Modules\AbilityValidator;

/**
 * Class AbilityRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Modules;
 */
class AbilityRepositoryEloquent extends BaseRepository implements AbilityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ability::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
