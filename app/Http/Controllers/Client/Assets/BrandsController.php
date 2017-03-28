<?php
namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\Brand;
use App\Etrack\Repositories\Assets\BrandRepository;
use App\Etrack\Transformers\Asset\BrandTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Asset\Config\BrandStoreRequest;
use App\Http\Request\Asset\Config\BrandUpdateRequest;
use DB;
use Exception;
use Yajra\Datatables\Datatables;

class BrandsController extends Controller
{

    /**
     * @var BrandRepository
     */
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->module = 'client-config-assets-brands';
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        $this->userCan('list');
        $brands = $this->brandRepository->scopeQuery(function (Brand $query) {
            return $query->inCompany();
        })->all();

        return $this->response->collection($brands, new BrandTransformer());
    }

    public function datatable()
    {
        return Datatables::of(Brand::inCompany())
            ->setTransformer(BrandTransformer::class)
            ->make(true);
    }

    public function show($id)
    {
        $this->userCan('show');
        $brand = Brand::inCompany()->find($id);
        if (!$brand) {
            $this->response->errorForbidden('No tienes permiso para ver esta Marca');
        }

        return $this->response->item($brand, new BrandTransformer());
    }

    public function store(BrandStoreRequest $request)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $user->load('company');

        $data = $request->all();
        DB::beginTransaction();
        try {
            $data['company_id'] = $user->company_id;
            $brand = $this->brandRepository->create($data);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($brand, new BrandTransformer());
    }

    public function update(BrandUpdateRequest $request, $brandId)
    {
        $this->userCan('update');
        $user = $this->loggedInUser();
        $brand = Brand::inCompany()->find($brandId);
        if (!$brand) {
            $this->response->errorForbidden('No tiene permiso para actualizar esta marca');
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $data['company_id'] = $user->company_id;
            $brand = $this->brandRepository->update($data, $brandId);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($brand, new BrandTransformer());
    }

    public function destroy($brandId)
    {
        $this->userCan('destroy');
        $brand = Brand::inCompany()->find($brandId);
        if (!$brand) {
            $this->response->errorForbidden('No tiene permiso para eliminar esta marca');
        }

        DB::beginTransaction();
        try {
            $brand->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        DB::commit();
        return response()->json(['message' => 'Marca Eliminada con Exito']);
    }
}