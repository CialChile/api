<?php

namespace App\Etrack\Repositories\Certification;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Certification\CertificationRepository;
use App\Etrack\Entities\Certification\Certification;
use App\Etrack\Validators\Certification\CertificationValidator;

/**
 * Class CertificationRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Certification;
 */
class CertificationRepositoryEloquent extends BaseRepository implements CertificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Certification::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
