<?php

namespace App\Etrack\Repositories\Company;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Entities\Company\Company;

/**
 * Class CompanyRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Company;
 */
class CompanyRepositoryEloquent extends BaseRepository implements CompanyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Company::class;
    }

}
