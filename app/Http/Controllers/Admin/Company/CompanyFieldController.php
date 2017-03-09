<?php
namespace App\Http\Controllers\Admin\Company;

use App\Etrack\Entities\Company\CompanyFields;
use App\Etrack\Repositories\Company\CompanyFieldsRepository;
use App\Etrack\Transformers\Company\CompanyFieldTransformer;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class CompanyFieldController extends Controller
{

    public $companyFieldRepository;

    public function __construct(CompanyFieldsRepository $companyRepository)
    {
        $this->module = 'company';
        $this->companyFieldRepository = $companyRepository;
    }


    public function index()
    {
        $this->userCan('list');
        $companies = $this->companyFieldRepository->scopeQuery(function (CompanyFields $query) {
            return $query->latest();
        })->paginate(10);

        return $this->response->paginator($companies, new CompanyFieldTransformer());
    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(CompanyFields::query())
            ->setTransformer(CompanyFieldTransformer::class)
            ->make(true);
    }

    public function list()
    {
        $this->userCan('see');
        $companies = $this->companyFieldRepository->scopeQuery(function (CompanyFields $query) {
            return $query->latest();
        })->all(['name', 'id']);

        return response()->json(['data' => $companies]);
    }

    public function show(CompanyFields $companyFields)
    {
        $this->userCan('see');
        return $this->response->item($companyFields, new CompanyFieldTransformer());

    }


    public function store(\Request $request)
    {
        $this->userCan('create');
        $data = $request->all();
        $companyFields = $this->companyFieldRepository->create($data);
        return $this->response->item($companyFields, new CompanyFieldTransformer());
    }

    public function update(\Request $request, CompanyFields $companyFields)
    {
        $this->userCan('update');
        $data = $request->all();

        $companyFields->fill($data);
        $companyFields->save();

        return $this->response->item($companyFields, new CompanyFieldTransformer());


    }

    public function destroy(CompanyFields $companyFields)
    {
        $this->userCan('destroy');
        $companyFields->delete();

        return $this->response->accepted();

    }

    public function destroyMany($ids)
    {

    }
}