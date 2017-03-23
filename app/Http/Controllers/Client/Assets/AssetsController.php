<?php

namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Repositories\Assets\AssetRepository;
use App\Etrack\Transformers\Asset\AssetTransformer;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class AssetsController extends Controller
{

    /**
     * @var AssetRepository
     */
    private $workerRepository;

    public function __construct(AssetRepository $workerRepository)
    {
        $this->module = 'client-assets';
        $this->workerRepository = $workerRepository;
    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Asset::inCompany())
            ->setTransformer(AssetTransformer::class)
            ->make(true);
    }
}
