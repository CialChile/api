<?php

namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\AssetConfiguration;
use App\Etrack\Repositories\Assets\AssetConfigurationRepository;
use App\Etrack\Transformers\Asset\AssetConfigurationTransformer;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;

class AssetsConfigurationController extends Controller
{
    /**
     * @var AssetConfigurationRepository
     */
    private $assetConfigurationRepository;

    public function __construct(AssetConfigurationRepository $assetConfigurationRepository)
    {
        $this->module = 'client-assets';
        $this->assetConfigurationRepository = $assetConfigurationRepository;
    }

    public function index()
    {
        $this->userCan('show');
        $assetConfig = AssetConfiguration::inCompany()->first();
        if (!$assetConfig) {
            $assetConfig = new AssetConfiguration();
        }
        return $this->response->item($assetConfig, new AssetConfigurationTransformer());
    }

    public function store(Request $request)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();

        $assetConfig = AssetConfiguration::inCompany()->first();
        if (!$assetConfig) {
            $assetConfig = new AssetConfiguration();
        }
        $data = $request->all();
        $data['company_id'] = $user->company_id;
        $assetConfig->fill($data);
        $assetConfig->save();
        return $this->response->item($assetConfig, new AssetConfigurationTransformer());
    }
}
