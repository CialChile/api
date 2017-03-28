<?php
namespace App\Http\Controllers\Client\Config;

use App\Etrack\Entities\Status;
use App\Etrack\Repositories\StatusRepository;
use App\Etrack\Transformers\StatusTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Config\StatusStoreRequest;
use App\Http\Request\Config\StatusUpdateRequest;
use DB;
use Yajra\Datatables\Datatables;

class StatusController extends Controller
{
    /**
     * @var StatusRepository
     */
    private $statusRepository;

    public function __construct(StatusRepository $statusRepository)
    {
        $this->module = 'client-config-status';
        $this->statusRepository = $statusRepository;
    }

    public function index($type = 0)
    {
        $this->userCan('list');
        $statuses = Status::inCompany()->where('type', $type)->get();
        return $this->response->collection($statuses, new StatusTransformer());
    }

    public function datatable()
    {
        return Datatables::of(Status::inCompany())
            ->setTransformer(StatusTransformer::class)
            ->filterColumn('type', function ($query, $keyword) {
                if ($keyword == 'activo' || $keyword == 'Activo') {
                    $query->where('type', [0]);
                }
                if ($keyword == 'documento' || $keyword == 'Documento') {
                    $query->where('type', [1]);
                }
            })
            ->make(true);
    }

    public function show($id)
    {
        $this->userCan('show');
        $status = Status::inCompany()->find($id);
        if (!$status) {
            $this->response->errorForbidden('No tienes permiso para ver este status');
        }

        return $this->response->item($status, new StatusTransformer());
    }

    public function store(StatusStoreRequest $request)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $user->load('company');

        $data = $request->all();
        DB::beginTransaction();
        $data['company_id'] = $user->company_id;
        $status = $this->statusRepository->create($data);

        DB::commit();

        return $this->response->item($status, new StatusTransformer());
    }

    public function update(StatusUpdateRequest $request, $statusId)
    {
        $this->userCan('update');
        $user = $this->loggedInUser();
        $status = Status::inCompany()->find($statusId);
        if (!$status) {
            $this->response->errorForbidden('No tiene permiso para actualizar este status');
        }
        $data = $request->all();
        DB::beginTransaction();
        $data['company_id'] = $user->company_id;
        $status = $this->statusRepository->update($data, $statusId);

        DB::commit();

        return $this->response->item($status, new StatusTransformer());
    }

    public function destroy($statusId)
    {
        $this->userCan('destroy');
        $status = Status::inCompany()->find($statusId);
        if (!$status) {
            $this->response->errorForbidden('No tiene permiso para eliminar este status');
        }

        DB::beginTransaction();
        $status->delete();

        DB::commit();
        return response()->json(['message' => 'Status Eliminado con Exito']);
    }
}