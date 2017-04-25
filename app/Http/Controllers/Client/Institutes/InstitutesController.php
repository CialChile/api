<?php
namespace App\Http\Controllers\Client\Institutes;

use App\Etrack\Entities\Institute\Institute;
use App\Etrack\Repositories\Institute\InstituteRepository;
use App\Etrack\Transformers\Institute\InstituteTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Institute\InstituteStoreRequest;
use App\Http\Requests\Institute\InstituteUpdateRequest;
use DB;
use Yajra\Datatables\Datatables;

class InstitutesController extends Controller
{
    /**
     * @var InstituteRepository
     */
    private $instituteRepository;

    public function __construct(InstituteRepository $instituteRepository)
    {
        $this->module = 'client-certifications-institutes';
        $this->instituteRepository = $instituteRepository;
    }

    public function index()
    {
        $this->userCan('list');
        $institutes = $this->instituteRepository->scopeQuery(function (Institute $query) {
            return $query->inCompany();
        })->all();

        return $this->response->collection($institutes, new InstituteTransformer());
    }

    public function datatable()
    {
        return Datatables::of(Institute::inCompany())
            ->setTransformer(InstituteTransformer::class)
            ->make(true);
    }

    public function show($id)
    {
        $this->userCan('show');
        $institute = Institute::inCompany()->find($id);
        if (!$institute) {
            $this->response->errorForbidden('No tienes permiso para ver este instituto');
        }

        return $this->response->item($institute, new InstituteTransformer());
    }

    public function store(InstituteStoreRequest $request)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $user->load('company');
        $data = $request->all();
        DB::beginTransaction();
        $data['company_id'] = $user->company_id;
        $institute = $this->instituteRepository->create($data);
        DB::commit();

        return $this->response->item($institute, new InstituteTransformer());
    }

    public function update(InstituteUpdateRequest $request, $instituteId)
    {
        $this->userCan('update');
        $user = $this->loggedInUser();
        $institute = Institute::inCompany()->find($instituteId);
        if (!$institute) {
            $this->response->errorForbidden('No tiene permiso para actualizar este instituto');
        }
        $data = $request->all();
        DB::beginTransaction();
        $data['company_id'] = $user->company_id;
        $institute = $this->instituteRepository->update($data, $instituteId);
        DB::commit();

        return $this->response->item($institute, new InstituteTransformer());
    }

    public function destroy($instituteId)
    {
        $this->userCan('destroy');
        $institute = Institute::inCompany()->find($instituteId);
        if (!$institute) {
            $this->response->errorForbidden('No tiene permiso para eliminar este instituto');
        }

        DB::beginTransaction();
        $institute->delete();
        DB::commit();
        return response()->json(['message' => 'Marca Eliminada con Exito']);
    }
}