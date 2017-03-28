<?php
namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\Brand;
use App\Etrack\Entities\Assets\BrandModel;
use App\Etrack\Repositories\Assets\BrandModelRepository;
use App\Etrack\Transformers\Asset\BrandModelTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Asset\Config\BrandModelStoreRequest;
use App\Http\Request\Asset\Config\BrandModelUpdateRequest;
use DB;
use Exception;
use Yajra\Datatables\Datatables;

class BrandModelsController extends Controller
{
    /**
     * @var BrandModelRepository
     */
    private $brandModelRepository;

    public function __construct(BrandModelRepository $brandModelRepository)
    {
        $this->module = 'client-config-assets-brand-models';
        $this->brandModelRepository = $brandModelRepository;
    }

    public function index($brandId)
    {
        $this->userCan('list');
        $brandModels = BrandModel::whereHas('brand', function ($query) {
            /** @var Brand $query */
            return $query->inCompany();
        })->where('brand_id',$brandId)->get();

        return $this->response->collection($brandModels, new BrandModelTransformer());
    }

    public function datatable()
    {
        return Datatables::of(BrandModel::whereHas('brand', function ($query) {
            /** @var Brand $query */
            return $query->inCompany();
        })->with('brand'))->setTransformer(BrandModelTransformer::class)
            ->make(true);
    }

    public function show($brandId, $brandModelId)
    {
        $this->userCan('show');
        $brand = Brand::inCompany()->find($brandId);
        if (!$brand) {
            $this->response->errorForbidden('No tienes permiso para ver este Modelo de la marca referenciada');
        }

        $brandModel = $brand->brandModels()->find($brandModelId);

        return $this->response->item($brandModel, new BrandModelTransformer());
    }

    public function store(BrandModelStoreRequest $request, $brandId)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $user->load('company');
        $brand = Brand::inCompany()->find($brandId);
        if (!$brand) {
            $this->response->errorForbidden('No tiene permiso para guardar este modelo en la marca especificada');
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $brandModel = $brand->brandModels()->create($data);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($brandModel, new BrandModelTransformer());
    }

    public function update(BrandModelUpdateRequest $request, $brandId, $brandModelId)
    {
        $this->userCan('update');
        $brand = Brand::inCompany()->find($brandId);
        if (!$brand) {
            $this->response->errorForbidden('No tiene permiso para actualizar este modelo en esta marca');
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $brandModel = $this->brandModelRepository->find($brandModelId);
            /** @var BrandModel $brandModel */
            $data['brand_id'] = $brandId;
            $brandModel = $brandModel->fill($data);
            $brandModel->save();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($brandModel, new BrandModelTransformer());
    }

    public function destroy($brandId, $brandModelId)
    {
        $this->userCan('destroy');
        $brand = Brand::inCompany()->find($brandId);
        if (!$brand) {
            $this->response->errorForbidden('No tiene permiso para eliminar este modelo de la marca especificada');
        }

        DB::beginTransaction();
        try {
            /** @var BrandModel $brandModel */
            $brandModel = $brand->brandModels()->find($brandModelId);
            $brandModel->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        DB::commit();
        return response()->json(['message' => 'Modelo Eliminado con Exito']);
    }
}