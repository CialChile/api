<?php

namespace App\Etrack\Repositories\Modules;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Modules\ModuleRepository;
use App\Etrack\Entities\Modules\Module;
use App\Etrack\Validators\Modules\ModuleValidator;

/**
 * Class ModuleRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Modules;
 */
class ModuleRepositoryEloquent extends BaseRepository implements ModuleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Module::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
