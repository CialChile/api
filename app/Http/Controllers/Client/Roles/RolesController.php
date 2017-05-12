<?php
namespace App\Http\Controllers\Client\Roles;

use App\Etrack\Entities\Auth\Role;
use App\Etrack\Repositories\Auth\RoleRepository;
use App\Etrack\Transformers\Auth\RoleTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Kodeine\Acl\Models\Eloquent\Permission;
use Yajra\Datatables\Datatables;

class RolesController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->module = 'client-security-roles';
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $this->userCan('list');
        $roles = $this->roleRepository->scopeQuery(function (Role $query) {
            return $query->inCompany()->latest();
        })->all();

        return $this->response->collection($roles, new RoleTransformer());
    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Role::inCompany())
            ->setTransformer(RoleTransformer::class)
            ->make(true);
    }

    public function show($roleId)
    {
        $this->userCan('show');
        return $this->response->item($this->roleRepository->find($roleId), new RoleTransformer());

    }

    public function store(RoleStoreRequest $request)
    {
        $this->userCan('store');
        $data = $request->all();
        $user = $this->loggedInUser();
        $permissions = collect($data['permissions']);

        $dataRole = [
            'name'        => $data['name'],
            'description' => $data['description'],
            'slug'        => str_slug($user->company_id . '-' . $data['name']),
            'company_id'  => $user->company_id
        ];
        DB::beginTransaction();
        /** @var Role $role */
        $role = $this->roleRepository->create($dataRole);
        $permissions->each(function ($permission) use ($role) {
            if (str_contains($permission['slug'], 'admin') === false) {
                $permissionsData = [
                    'name' => $permission['slug'],
                ];
                unset($permission['name']);
                unset($permission['slug']);
                $permissionsData['slug'] = $permission;

                $perm = Permission::create($permissionsData);
                $role->assignPermission($perm);
            }
        });

        DB::commit();
        return $this->response->item($role, new RoleTransformer());

    }

    public function update(RoleUpdateRequest $request, $roleId)
    {
        $this->userCan('update');
        $data = $request->all();
        $user = $this->loggedInUser();
        $permissions = collect($data['permissions']);
        $roles = $this->roleRepository->findWhere(['id' => $roleId, 'company_id' => $user->company_id]);

        if (!$roles->count()) {
            $this->response->errorForbidden('No tiene permiso para actualizar este rol');
        }

        $dataRole = [
            'name'        => $data['name'],
            'description' => $data['description'],
            'slug'        => str_slug($user->company_id . '-' . $data['name']),
        ];
        DB::beginTransaction();
        /** @var Role $role */
        $role = $this->roleRepository->update($dataRole, $roleId);
        $role->permissions()->delete();
        $role->revokeAllPermissions();
        $permissions->each(function ($permission) use ($role) {
            if (str_contains($permission['slug'], 'admin') === false) {
                $permissionsData = [
                    'name' => $permission['slug'],
                ];
                unset($permission['name']);
                unset($permission['slug']);
                $permissionsData['slug'] = $permission;

                $perm = Permission::create($permissionsData);
                $role->assignPermission($perm);
            }
        });

        DB::commit();
        return $this->response->item($role, new RoleTransformer());

    }

    public function destroy($roleId)
    {
        $this->userCan('destroy');
        $user = $this->loggedInUser();
        /** @var Collection $role */
        $roles = $this->roleRepository->findWhere(['id' => $roleId, 'company_id' => $user->company_id]);
        if (!$roles->count()) {
            $this->response->errorForbidden('No tiene permiso para eliminar este rol');
        }
        /** @var Role $role */
        $role = $roles->first();
        if ($role->users->count()) {
            $this->response->errorForbidden('Hay usuarios que pertenecen a este Rol, por lo tanto no puede ser eliminado');
        };
        DB::beginTransaction();
        try {
            $role->permissions()->delete();
            $role->revokeAllPermissions();
            $role->delete();

        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        DB::commit();
        return response()->json(['message' => 'Rol Eliminado con Exito']);

    }
}