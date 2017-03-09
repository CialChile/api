<?php
namespace App\Http\Controllers\Admin\Company;

use App\Etrack\Entities\Auth\User;
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

    public function show($companyId)
    {
        $this->userCan('see');
        return $this->response->item($this->companyRepository->find($companyId), new CompanyTransformer());

    }

    public function store(CompanyStoreRequest $request)
    {
        $this->userCan('create');
        $data = $request->all();
        $data['active'] = true;
        $userData = $data['user'];
        unset($data['user']);
        $randomPassword = str_random(8);
        $userData['password'] = bcrypt($randomPassword);
        $userData['company_admin'] = true;
        /** @var Company $company */
        $company = $this->companyRepository->create($data);
        /** @var User $user */
        $user = $company->users()->create($userData);
        Mail::to($user->email)->send(new UserRegistered($user, $randomPassword));

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

        $user = User::where('company_id', $company->id)->where('company_admin', true)->first();
        if ($user->email != $userData['email']) {
            $randomPassword = str_random(8);
            $userData['password'] = bcrypt($randomPassword);
            $user->fill($userData);
            $user->save();
            Mail::to($user->email)->send(new UserRegistered($user, $randomPassword));
        } else {
            $user->fill($userData);
            unset($userData['password']);
            $user->save();
        }
        return $this->response->item($company, new CompanyTransformer());

    }

    public function destroy(Company $company)
    {
        $this->userCan('destroy');
        $company->delete();

        return $this->response->accepted();

    }

}