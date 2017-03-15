<?php
namespace App\Http\Controllers\Client\User;

use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\Worker\Worker;
use App\Etrack\Repositories\Auth\UserRepository;
use App\Etrack\Repositories\Worker\WorkerRepository;
use App\Etrack\Services\Auth\UserService;
use App\Etrack\Transformers\Auth\UserTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\User\SecureUserStoreRequest;
use App\Http\Request\User\SecureUserUpdateRequest;
use DB;
use Exception;
use Yajra\Datatables\Datatables;

class SecureUserController extends Controller
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
        $this->module = 'client-security-users';
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->workerRepository = $workerRepository;
    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(User::inCompany())
            ->setTransformer(UserTransformer::class)
            ->make(true);
    }

    public function show($userId)
    {
        $this->userCan('show');
        $user = User::inCompany()->find($userId);
        if (!$user) {
            $this->response->errorForbidden('No tienes permiso para ver este usuario');
        }

        return $this->response->item($user, new UserTransformer());
    }

    public function store(SecureUserStoreRequest $request)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $user->load('company');

        $usersInCompanyCount = User::inCompany()->count();
        if ($usersInCompanyCount >= $user->company->users_number) {
            $this->response->errorForbidden('Ya alcanzo la cuota de usuarios permitidos, para aumentar su cuota por favor comuniquese con su proveedor');
        }

        $data = $request->all();
        DB::beginTransaction();
        try {
            $randomPassword = $this->userService->generateRandomPassword();
            $data['password'] = bcrypt($randomPassword);
            $data['company_id'] = $user->company_id;
            /** @var User $newUser */
            $worker = Worker::create($data);
            $data['worker_id'] = $worker->id;
            $newUser = $this->userRepository->create($data);
            $newUser->syncRoles($data['role']);
            $this->userService->sendUserWasRegisteredMail($newUser, $randomPassword);

        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($newUser, new UserTransformer());
    }

    public function update(SecureUserUpdateRequest $request, $userId)
    {
        $this->userCan('update');
        $userToUpdate = User::inCompany()->find($userId);
        if (!$userToUpdate) {
            $this->response->errorForbidden('No tiene permiso para actualizar este usuario');
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            if ($userToUpdate->email != $data['email']) {
                $randomPassword = $this->userService->generateRandomPassword();
                $data['password'] = bcrypt($randomPassword);
                $userToUpdate->fill($data);
                $userToUpdate->save();
                $this->userService->sendUserWasRegisteredMail($userToUpdate, $randomPassword);
            } else {
                $userToUpdate->fill($data);
                $userToUpdate->save();
            }
            $userToUpdate->worker()->update($data);
            $userToUpdate->syncRoles($data['role']);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($userToUpdate, new UserTransformer());
    }

    public function destroy($userId)
    {
        $this->userCan('destroy');
        $userToDestroy = User::inCompany()->find($userId);
        if (!$userToDestroy) {
            $this->response->errorForbidden('No tiene permiso para eliminar este usuario');
        }

        DB::beginTransaction();
        try {
            $userToDestroy->worker()->delete();
            $userToDestroy->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        DB::commit();
        return response()->json(['message' => 'Usuario Eliminado con Exito']);

    }

}