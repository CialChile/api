<?php
namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\Workplace;
use App\Etrack\Repositories\Assets\WorkplaceRepository;
use App\Etrack\Transformers\Asset\WorkplaceTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Asset\Config\WorkplaceStoreRequest;
use App\Http\Request\Asset\Config\WorkplaceUpdateRequest;
use DB;
use Exception;
use Yajra\Datatables\Datatables;

class WorkplacesController extends Controller
{
    /**
     * @var WorkplaceRepository
     */
    private $workplaceRepository;

    public function __construct(WorkplaceRepository $workplaceRepository)
    {
        $this->module = 'client-config-assets-workplaces';
        $this->workplaceRepository = $workplaceRepository;
    }

    public function index()
    {
        $this->userCan('list');
        $workplaces = $this->workplaceRepository->scopeQuery(function (Workplace $query) {
            return $query->inCompany();
        })->all();

        return $this->response->collection($workplaces, new WorkplaceTransformer());
    }

    public function datatable()
    {
        return Datatables::of(Workplace::inCompany())
            ->setTransformer(WorkplaceTransformer::class)
            ->make(true);
    }

    public function show($id)
    {
        $this->userCan('show');
        $workplace = Workplace::inCompany()->find($id);
        if (!$workplace) {
            $this->response->errorForbidden('No tienes permiso para ver este Lugar de Trabajo');
        }

        return $this->response->item($workplace, new WorkplaceTransformer());
    }

    public function store(WorkplaceStoreRequest $request)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $data = $request->all();
        DB::beginTransaction();
        try {
            $data['company_id'] = $user->company_id;
            $workplace = $this->workplaceRepository->create($data);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($workplace, new WorkplaceTransformer());
    }

    public function update(WorkplaceUpdateRequest $request, $workplaceId)
    {
        $this->userCan('update');
        $user = $this->loggedInUser();
        $workplace = Workplace::inCompany()->find($workplaceId);
        if (!$workplace) {
            $this->response->errorForbidden('No tiene permiso para actualizar este lugar de trabajo');
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $data['company_id'] = $user->company_id;
            $workplace = $this->workplaceRepository->update($data, $workplaceId);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($workplace, new WorkplaceTransformer());
    }

    public function destroy($workplaceId)
    {
        $this->userCan('destroy');
        $workplace = Workplace::inCompany()->find($workplaceId);
        if (!$workplace) {
            $this->response->errorForbidden('No tiene permiso para eliminar este lugar de trabajo');
        }

        DB::beginTransaction();
        try {
            $workplace->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        DB::commit();
        return response()->json(['message' => 'Lugar de trabajo Eliminado con Exito']);
    }
}