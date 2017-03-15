<?php
namespace App\Http\Controllers\Client\User;

use App\Etrack\Transformers\Auth\UserTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\User\UserChangePasswordRequest;
use App\Http\Request\User\UserUpdateRequest;

class UserController extends Controller
{

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->loggedInUser();
        $user->load('worker');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->save();

        $worker = $user->worker;
        $worker->first_name = $request->get('first_name');
        $worker->last_name = $request->get('last_name');
        $worker->save();

        return $this->response->item($user, new UserTransformer());
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        $user = $this->loggedInUser();
        $oldPassword = $request->get('old_password');
        if (!\Hash::check($oldPassword, $user->password)) {
            return $this->response->errorForbidden('La contraseña actual no coincide con nuestros registros');
        }
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada con exito']);
    }

}