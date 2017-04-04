<?php
namespace App\Http\Controllers\Admin\Company;

use App\Etrack\Entities\Company\Company;
use App\Etrack\Repositories\Company\CompanyRepository;
use App\Etrack\Scopes\CompanyScope;
use App\Etrack\Services\Admin\Company\CompanyService;
use App\Etrack\Transformers\Company\CompanyTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Company\CompanyStoreRequest;
use App\Http\Request\Company\CompanyUpdateRequest;
use DB;
use Dotenv\Exception\ValidationException;
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
        $this->module = 'admin-companies';
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
        $company = Company::find($companyId);
        return $this->response->item($company, new CompanyTransformer());

    }

    public function store(CompanyStoreRequest $request)
    {
        $this->userCan('store');
        $data = $request->all();
        $data['active'] = true;
        $userData = $data['responsible'];
        unset($data['responsible']);
        DB::beginTransaction();
        $company = $this->companyRepository->create($data);
        $worker = $this->companyService->saveWorker($company, $userData);
        $this->companyService->saveAdminUser($company, $userData, $worker);
        DB::commit();
        return $this->response->item($company, new CompanyTransformer());

    }

    public function update(CompanyUpdateRequest $request, $companyId)
    {
        $this->userCan('update');
        $company = $this->companyRepository->find($companyId);
        $data = $request->all();
        $userData = $data['responsible'];
        unset($data['responsible']);
        DB::beginTransaction();
        $company->fill($data);
        $company->save();
        $user = $this->companyService->updateAdminUser($company, $userData);
        $worker = $this->companyService->updateWorker($userData, $user);
        DB::commit();

        return $this->response->item($company, new CompanyTransformer());

    }

    public function destroy(Company $company)
    {
        $this->userCan('destroy');
        DB::beginTransaction();
        $company->delete();
        DB::commit();
        return $this->response->accepted();

    }

    public function toggleActive($companyId)
    {
        $this->userCan('update');
        DB::beginTransaction();
        $company = $this->companyRepository->find($companyId);
        $company->active = !$company->active;
        $company->save();
        DB::commit();
        return $this->response->item($company, new CompanyTransformer());
    }

}