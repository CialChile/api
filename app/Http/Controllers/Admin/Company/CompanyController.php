<?php
namespace App\Http\Controllers\Admin\Company;

use App\Etrack\Entities\Company\Company;
use App\Etrack\Repositories\Auth\UserRepository;
use App\Etrack\Repositories\Company\CompanyRepository;
use App\Etrack\Transformers\Company\CompanyTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Company\CompanyStoreRequest;
use App\Http\Request\Company\CompanyUpdateRequest;
use App\Mail\UserRegistered;
use Mail;
use Yajra\Datatables\Datatables;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(CompanyRepository $companyRepository, UserRepository $userRepository)
    {
        $this->module = 'company';
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
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

    public function show(Company $company)
    {
        $this->userCan('see');
        return $this->response->item($company, new CompanyTransformer());

    }

    public function store(CompanyStoreRequest $request)
    {
        $this->userCan('create');
        $data = $request->get('company');
        $userData = $request->get('user');
        $randomPassword = str_random(8);
        $userData['password'] = bcrypt($randomPassword);
        $company = $this->companyRepository->create($data);
        $user = $this->userRepository->create($userData);
        Mail::to($user->email)->send(new UserRegistered($user, $randomPassword));

        return $this->response->item($company, new CompanyTransformer());

    }

    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $this->userCan('update');
        $data = $request->all();

        $company->fill($data);
        $company->save();

        return $this->response->item($company, new CompanyTransformer());

    }

    public function destroy(Company $company)
    {
        $this->userCan('destroy');
        $company->delete();

        return $this->response->accepted();

    }

}