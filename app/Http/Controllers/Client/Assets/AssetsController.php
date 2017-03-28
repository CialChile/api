<?php

namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Repositories\Assets\AssetRepository;
use App\Etrack\Transformers\Asset\AssetTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Asset\AssetStoreRequest;
use App\Http\Request\Asset\AssetUpdateRequest;
use DB;
use Yajra\Datatables\Datatables;

class AssetsController extends Controller
{

    /**
     * @var AssetRepository
     */
    private $assetRepository;

    public function __construct(AssetRepository $assetRepository)
    {
        $this->module = 'client-assets';
        $this->assetRepository = $assetRepository;
    }

    public function index()
    {

    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Asset::inCompany()->with(['brand','category','subcategory','brandModel','status','workplace'])->select('assets.*'))
            ->setTransformer(AssetTransformer::class)
            ->make(true);
    }

    public function store(AssetStoreRequest $request)
    {
        $user = $this->loggedInUser();
        $data = $request->all();
        DB::beginTransaction();
        $data['company_id'] = $user->company_id;
        $asset = new Asset();
        $asset->fill($data);
        $asset->save();
        if ($request->hasFile('image')) {
            $asset->clearMediaCollection('cover');
            $asset->addMedia($request->file('image'))->preservingOriginal()->toMediaLibrary('cover');
        }

        DB::commit();
        return $this->response->item($asset, new AssetTransformer());

    }

    public function update(AssetUpdateRequest $request, $assetId)
    {

    }

    public function destroy($assetId)
    {

    }
}
