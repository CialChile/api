<?php
namespace App\Http\Controllers\Client\Users;

use App\Etrack\Entities\Activity\ActivityScheduleExecution;
use App\Etrack\Transformers\Auth\UserTransformer;
use App\Etrack\Transformers\Events\UserEventTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserChangePasswordRequest;
use App\Http\Requests\User\UserUpdateRequest;
use Dingo\Api\Http\Request;

class UsersController extends Controller
{

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->loggedInUser();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->timezone = $request->get('timezone');
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

    public function events(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $user = $this->loggedInUser();
        $executions = ActivityScheduleExecution::whereBetween('execution_date', [$start, $end])->where(function ($q) use ($user) {
            $q->whereHas('activitySchedule', function ($q2) use ($user) {
                $q2->where('operator_id', $user->id);
            })->orWhereHas('activitySchedule.activity', function ($q3) use ($user) {
                $q3->where('supervisor_id', $user->id);
            });
        })
            ->with(['status', 'activitySchedule.activity'])
            ->get();

        return $this->response->collection($executions, new UserEventTransformer());

    }

}