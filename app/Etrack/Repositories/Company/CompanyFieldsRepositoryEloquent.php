<?php

namespace App\Etrack\Repositories\Company;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Company\CompanyFieldsRepository;
use App\Etrack\Entities\Company\CompanyFields;
use App\Etrack\Validators\Company\CompanyFieldsValidator;

/**
 * Class CompanyFieldsRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Company;
 */
class CompanyFieldsRepositoryEloquent extends BaseRepository implements CompanyFieldsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CompanyFields::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
