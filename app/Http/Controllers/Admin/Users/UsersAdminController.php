<?php
namespace App\Http\Controllers\Admin\Users;

use App\Etrack\Entities\Auth\Role;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Repositories\Auth\UserRepository;
use App\Etrack\Repositories\Worker\WorkerRepository;
use App\Etrack\Services\Auth\UserService;
use App\Etrack\Transformers\Auth\UserTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Admin\User\AdminUserStoreRequest;
use App\Http\Request\Admin\User\AdminUserUpdateRequest;
use DB;
use Yajra\Datatables\Datatables;

class UsersAdminController extends Controller
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var WorkerRepository
     */
    private $workerRepository;

    public function __construct(UserRepository $userRepository, WorkerRepository $workerRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->workerRepository = $workerRepository;
    }

    public function datatable()
    {
        return Datatables::of(User::whereNull('company_id'))
            ->setTransformer(UserTransformer::class)
            ->make(true);
    }

    public function show($userId)
    {
        $user = User::whereNull('company_id')->find($userId);
        if (!$user) {
            $this->response->errorForbidden('No tienes permiso para ver este usuario');
        }

        return $this->response->item($user, new UserTransformer());
    }

    public function store(AdminUserStoreRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        $randomPassword = $this->userService->generateRandomPassword();
        $data['password'] = bcrypt($randomPassword);
        /** @var User $newUser */
        $newUser = $this->userRepository->create($data);
        $newUser->assignRole('administrator');
        $this->userService->sendUserWasRegisteredMail($newUser, $randomPassword);
        DB::commit();

        return $this->response->item($newUser, new UserTransformer());
    }

    public function update(AdminUserUpdateRequest $request, $userId)
    {
        $userToUpdate = User::whereNull('company_id')->find($userId);
        if (!$userToUpdate) {
            $this->response->errorForbidden('No tiene permiso para actualizar este usuario');
        }
        $data = $request->all();
        DB::beginTransaction();
        $userToUpdate->first_name = $data['first_name'];
        $userToUpdate->last_name = $data['last_name'];
        $userToUpdate->active = $data['active'];
        $userToUpdate->save();
        DB::commit();
        return $this->response->item($userToUpdate, new UserTransformer());
    }

    public function destroy($userId)
    {
        $userToDestroy = User::whereNull('company_id')->find($userId);
        if (!$userToDestroy) {
            $this->response->errorForbidden('No tiene permiso para eliminar este usuario');
        }

        DB::beginTransaction();
        $userToDestroy->delete();
        DB::commit();
        return response()->json(['message' => 'Usuario Eliminado con Exito']);

    }

}