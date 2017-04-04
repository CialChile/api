<?php
namespace App\Etrack\Services\Admin\Company;

use App\Etrack\Entities\Auth\Role;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\Company\Company;
use App\Etrack\Entities\Worker\Worker;
use App\Etrack\Services\Auth\RoleService;
use App\Etrack\Services\Auth\UserService;
use Illuminate\Validation\ValidationException;

class CompanyService
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var RoleService
     */
    private $roleService;

    /**
     * CompanyService constructor.
     * @param UserService $userService
     * @param RoleService $roleService
     */
    public function __construct(UserService $userService, RoleService $roleService)
    {

        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function saveAdminUser(Company $company, array $userData, Worker $worker)
    {
        /** @var User $user */
        $randomPassword = $this->userService->generateRandomPassword();
        $userData['password'] = bcrypt($randomPassword);
        $userData['company_admin'] = true;
        $userData['active'] = true;
        $userData['worker_id'] = $worker['id'];
        $user = $company->users()->create($userData);
        $roleData = [
            'name'        => 'Administrador',
            'company_id'  => $company->id,
            'slug'        => str_slug($company->id . '-' . 'Administrador'),
            'description' => 'Usuario Administrador'
        ];
        $role = new Role($roleData);
        $user->roles()->save($role);
        $this->roleService->addFullPermissionToRole($role);
        return $this->userService->sendUserWasRegisteredMail($user, $randomPassword);
    }

    /**
     * @param Company $company
     * @param array $userData
     * @return User
     */
    public function updateAdminUser(Company $company, array $userData):User
    {
        $user = User::where('company_id', $company->id)->where('company_admin', true)->first();
        if ($user->email != $userData['email']) {
            $randomPassword = $this->userService->generateRandomPassword();
            $userData['password'] = bcrypt($randomPassword);
            $user->fill($userData);
            $user->save();
            $this->userService->sendUserWasRegisteredMail($user, $randomPassword);
        } else {
            $user->fill($userData);
            unset($userData['password']);
            $user->save();
        }

        return $user;
    }

    /**
     * @param Company $company
     * @param array $userData
     * @return Worker|\Illuminate\Database\Eloquent\Model
     */
    public function saveWorker(Company $company, array $userData)
    {
        return $company->workers()->create($userData);
    }

    public function updateWorker(array $userData, User $user):Worker
    {
        $worker = $user->worker;
        $worker->fill($userData);
        $worker->save();
        return $worker;
    }
}