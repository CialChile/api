<?php

namespace App\Etrack\Repositories\Certification;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Repositories\Certification\CertificationWorkerAssetRepository;
use App\Etrack\Entities\Certification\CertificationWorkerAsset;
use App\Etrack\Validators\Certification\CertificationWorkerAssetValidator;

/**
 * Class CertificationWorkerAssetRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Certification;
 */
class CertificationWorkerAssetRepositoryEloquent extends BaseRepository implements CertificationWorkerAssetRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CertificationWorkerAsset::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
