<?php
namespace App\Http\Controllers\Client\Users;

use App\Etrack\Transformers\Auth\UserTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserChangePasswordRequest;
use App\Http\Requests\User\UserUpdateRequest;

class UsersController extends Controller
{

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->loggedInUser();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->save();
        if ($request->hasFile('image')) {
            $user->clearMediaCollection('profile');
            $user->addMedia($request->file('image'))->preservingOriginal()->toMediaLibrary('profile');
        } elseif ($request->has('removeImage')) {
            $user->clearMediaCollection('profile');
        }

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