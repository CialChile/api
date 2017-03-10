<?php
namespace App\Http\Controllers\Admin\Company;

use App\Etrack\Entities\Company\Company;
use App\Etrack\Repositories\Company\CompanyRepository;
use App\Etrack\Services\Admin\Company\CompanyService;
use App\Etrack\Transformers\Company\CompanyTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Company\CompanyStoreRequest;
use App\Http\Request\Company\CompanyUpdateRequest;
use Yajra\Datatables\Datatables;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var CompanyService
     */
    private $companyService;

    public function __construct(CompanyRepository $companyRepository,
                                CompanyService $companyService)
    {
        $this->module = 'admin-company';
        $this->companyRepository = $companyRepository;
        $this->companyService = $companyService;
    }

    public function index()
    {
        $this->userCan('list');
        $companies = $this->companyRepository->scopeQuery(function (Company $query) {
            return $query->latest();
        })->paginate(10);

        return $this->response->paginator($companies, new CompanyTransformer());
    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Company::query())
            ->setTransformer(CompanyTransformer::class)
            ->make(true);
    }

    public function show($companyId)
    {
        $this->userCan('show');
        return $this->response->item($this->companyRepository->find($companyId), new CompanyTransformer());

    }

    public function store(CompanyStoreRequest $request)
    {
        $this->userCan('store');
        $data = $request->all();
        $data['active'] = true;
        $userData = $data['user'];
        unset($data['user']);
        $company = $this->companyRepository->create($data);
        $this->companyService->saveAdminUser($company, $userData);
        return $this->response->item($company, new CompanyTransformer());

    }

    public function update(CompanyUpdateRequest $request, $companyId)
    {
        $this->userCan('update');
        $company = $this->companyRepository->find($companyId);
        $data = $request->all();
        $userData = $data['user'];
        unset($data['user']);
        $company->fill($data);
        $company->save();
        $this->companyService->updateAdminUser($company, $userData);


        return $this->response->item($company, new CompanyTransformer());

    }

    public function destroy(Company $company)
    {
        $this->userCan('destroy');
        $company->delete();

        return $this->response->accepted();

    }

}