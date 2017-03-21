<?php
namespace App\Http\Controllers\Client\Worker;

use App\Etrack\Entities\Worker\Worker;
use App\Etrack\Repositories\Worker\WorkerRepository;
use App\Etrack\Transformers\Worker\WorkerTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Worker\WorkerStoreRequest;
use App\Http\Request\Worker\WorkerUpdateRequest;
use Carbon\Carbon;
use DB;
use Exception;
use Yajra\Datatables\Datatables;

class WorkerController extends Controller
{
    /**
     * @var WorkerRepository
     */
    private $workerRepository;

    public function __construct(WorkerRepository $workerRepository)
    {
        $this->module = 'client-rrhh-workers';
        $this->workerRepository = $workerRepository;
    }

    public function index()
    {
        $this->userCan('list');
        $workers = $this->workerRepository->scopeQuery(function (Worker $query) {
            return $query->inCompany()->latest();
        })->paginate(10);

        return $this->response->paginator($workers, new WorkerTransformer());
    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Worker::inCompany())
            ->setTransformer(WorkerTransformer::class)
            ->make(true);
    }

    public function show($workerId)
    {
        $this->userCan('show');
        return $this->response->item($this->workerRepository->find($workerId), new WorkerTransformer());

    }

    public function store(WorkerStoreRequest $request)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $data = $request->all();
        $data['birthday'] = Carbon::createFromFormat('d/m/Y', $data['birthday']);
        $data['company_id'] = $user->company_id;
        DB::beginTransaction();
        try {
            $worker = $this->workerRepository->create($data);
            if ($request->hasFile('image')) {
                $worker->clearMediaCollection('profile');
                $worker->addMedia($request->file('image'))->preservingOriginal()->toMediaLibrary('profile');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();
        return $this->response->item($worker, new WorkerTransformer());

    }

    public function update(WorkerUpdateRequest $request, $workerId)
    {
        $this->userCan('update');
        //  dd($request->hasFile('image') ? 'si' : 'no');
        DB::beginTransaction();
        try {
            /** @var Worker $worker */
            $worker = $this->workerRepository->find($workerId);
            $data = $request->all();
            $data['birthday'] = Carbon::createFromFormat('d/m/Y', $data['birthday']);
            $data['active'] = $data['active'] ? 1 : 0;
            $worker->fill($data);
            $worker->save();
            if ($request->hasFile('image')) {
                $worker->clearMediaCollection('profile');
                $worker->addMedia($request->file('image'))->preservingOriginal()->toMediaLibrary('profile');
            } elseif ($request->has('removeImage')) {
                $worker->clearMediaCollection('profile');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($worker, new WorkerTransformer());

    }

    public function destroy($workerId)
    {
        $this->userCan('destroy');
        $workerToDestroy = Worker::with('user')->inCompany()->find($workerId);
        if (!$workerToDestroy) {
            $this->response->errorForbidden('No tiene permiso para eliminar este trabajador');
        }
        if ($workerToDestroy->user) {
            if ($workerToDestroy->user->company_admin) {
                $this->response->errorForbidden('No puede eliminar este trabajador porque esta asociado al usuario administrador de la empresa');
            }
        }
        DB::beginTransaction();
        try {
            if ($workerToDestroy->user) {
                $workerToDestroy->user()->delete();
            }
            $workerToDestroy->delete();

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();
        return response()->json(['message' => 'Trabajador Eliminado con Exito']);

    }

}