<?php
namespace App\Http\Controllers\Auth;

use App\Etrack\Transformers\Auth\UserTransformer;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    
    public function login(Request $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!\Auth::attempt($credentials)) {
                return response()->json(['error' => 'las credenciales proporcionadas no son correctas'], 401);
            }

            $user = \Auth::user()->load('company');
            if (!$user->active) {
                if (\Auth::check()) {
                    try {
                        \Auth::logout();
                    } catch (JWTException $e) {
                    }
                }
                return response()->json(['error' => 'Este usuario se encuentra inhabilitado en el sistema, por favor contacte con el administrador'], 401);
            }

            if ($user->company) {
                if (!$user->company->active) {
                    if (\Auth::check()) {
                        try {
                            \Auth::logout();
                        } catch (JWTException $e) {
                        }
                    }
                    return response()->json(['error' => 'La empresa a la que pertenece este usuario se encuentra inhabilitado en el sistema, por favor contacte con el administrador'], 401);
                }
            }

            $token = $JWTAuth->fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token de verificación por favor contacte con el administrador '], 500);
        }

        return response()->json(compact('token'));
    }

    public function logout(JWTAuth $JWTAuth)
    {
        $JWTAuth->invalidate($JWTAuth->getToken());
        return response()->json(['message' => 'ok']);
    }

    public function user()
    {
        $user = \Auth::user();
        $user->load('roles');
        return $this->response->item($user, new UserTransformer());
    }

    public function permissions()
    {
        return ['permiso', 'permiso2'];

    }

}