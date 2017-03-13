<?php
namespace App\Http\Controllers\Client\Worker;

use App\Etrack\Entities\Worker\Worker;
use App\Etrack\Repositories\Worker\WorkerRepository;
use App\Etrack\Transformers\Worker\WorkerTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Worker\WorkerStoreRequest;
use App\Http\Request\Worker\WorkerUpdateRequest;
use Yajra\Datatables\Datatables;

class WorkerController extends Controller
{
    /**
     * @var WorkerRepository
     */
    private $workerRepository;

    public function __construct(WorkerRepository $workerRepository)
    {
        $this->module = 'client-worker';
        $this->workerRepository = $workerRepository;
    }

    public function index()
    {
        $this->userCan('list');
        $workers = $this->workerRepository->scopeQuery(function (Worker $query) {
            return $query->latest();
        })->paginate(10);

        return $this->response->paginator($workers, new WorkerTransformer());
    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Worker::query())
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
        $data = $request->all();
        $worker = $this->workerRepository->create($data);
        return $this->response->item($worker, new WorkerTransformer());

    }

    public function update(WorkerUpdateRequest $request, $workerId)
    {
        $this->userCan('update');
        $worker = $this->workerRepository->find($workerId);
        $data = $request->all();
        $worker->fill($data);
        $worker->save();

        return $this->response->item($worker, new WorkerTransformer());

    }

    public function destroy($workerId)
    {
        $this->userCan('destroy');
        $worker = $this->workerRepository->find($workerId);
        $worker->delete();

        return $this->response->accepted();

    }

}