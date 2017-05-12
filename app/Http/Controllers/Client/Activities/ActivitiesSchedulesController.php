<?php
namespace App\Http\Controllers\Client\Activities;

use App\Etrack\Entities\Activity\Activity;
use App\Etrack\Entities\Activity\ActivityMaterial;
use App\Etrack\Entities\Activity\ActivityObservation;
use App\Etrack\Entities\Activity\ActivityProcedure;
use App\Etrack\Entities\Activity\ActivitySchedule;
use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Transformers\Activity\ActivityScheduleTransformer;
use App\Etrack\Transformers\Activity\ActivityTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityScheduleStoreRequest;
use App\Http\Requests\Activity\ActivityScheduleUpdateRequest;
use App\Http\Requests\Activity\ActivityStoreRequest;
use App\Http\Requests\Activity\ActivityUpdateRequest;
use Carbon\Carbon;
use Datatables;
use DB;

class ActivitiesSchedulesController extends Controller
{

    public function __construct()
    {
        $this->module = 'client-activities-schedules';

    }

    public function index()
    {

    }

    public function datatable()
    {

    }

    public function show($activityId, $id)
    {
        $this->userCan('show');
        /** @var Activity $activity */
        $activity = Activity::inCompany()->find($activityId);
        if (!$activity) {
            $this->response->errorForbidden('No tienes permiso para ver esta programación');
        }

        $schedule = $activity->schedules()->find($id);
        if (!$schedule) {
            $this->response->errorForbidden('No tienes permiso para ver esta programación');
        }

        return $this->response->item($schedule, new ActivityScheduleTransformer());
    }

    public function store(ActivityScheduleStoreRequest $request, $activityId)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $operatorId = $request->get('operator')['id'];
        $program = $request->get('schedule');
        $assets = collect($request->get('assets'));
        /** @var Activity $activity */
        $activity = Activity::inCompany()->find($activityId);
        if (!$activity) {
            return $this->response->errorForbidden('No tienes permiso para generar programaciones a la actividad');
        }
        DB::beginTransaction();
        $schedule = new ActivitySchedule();
        $schedule->operator_id = $operatorId;
        $schedule->creator_id = $user->id;
        $schedule->program_type_slug = $program['programType']['slug'];
        $schedule->frequency = $program['frequency']['slug'];
        $schedule->periodicity = $program['periodicity'];
        $schedule->start_time = Carbon::parse($program['initHour'])->toTimeString();
        $schedule->estimated_duration = $program['estimatedTime'];
        $schedule->estimated_duration_unit = $program['estimatedTimeUnit']['slug'];
        $schedule->days = $program['days'];
        $schedule->day_of_month = $program['dayOfMonth'];
        $schedule->config = $program;
        $assets->each(function ($asset) use ($schedule, $activity) {
            $newSchedule = $schedule->replicate();
            $newSchedule->asset()->associate($asset['id']);
            $activity->schedules()->save($newSchedule);
        });

        if ($assets->isEmpty()) {
            $activity->schedules()->save($schedule);
        }

        DB::commit();
        return $this->response->item($schedule, new ActivityScheduleTransformer());
    }

    public function update(ActivityScheduleUpdateRequest $request, $activityId, $id)
    {
        $this->userCan('update');
        $this->userCan('store');
        $user = $this->loggedInUser();
        $operatorId = $request->get('operator')['id'];
        $program = $request->get('schedule');
        $asset = collect($request->get('asset'));
        /** @var Activity $activity */
        $activity = Activity::inCompany()->find($activityId);
        if (!$activity) {
            return $this->response->errorForbidden('No tienes permiso para generar programaciones a la actividad');
        }

        $schedule = $activity->schedules()->find($id);

        if (!$schedule) {
            return $this->response->errorForbidden('No se encontró la programación en nuestros registros');
        }
        DB::beginTransaction();
        $schedule->operator_id = $operatorId;
        $schedule->creator_id = $user->id;
        $schedule->program_type_slug = $program['programType']['slug'];
        $schedule->frequency = $program['frequency']['slug'];
        $schedule->periodicity = $program['periodicity'];
        $schedule->start_time = Carbon::parse($program['initHour'])->toTimeString();
        $schedule->estimated_duration = $program['estimatedTime'];
        $schedule->estimated_duration_unit = $program['estimatedTimeUnit']['slug'];
        $schedule->days = $program['days'];
        $schedule->day_of_month = $program['dayOfMonth'];
        $schedule->config = $program;
        $schedule->asset()->associate($asset['id']);
        $schedule->save();
        DB::commit();
        return $this->response->item($schedule, new ActivityScheduleTransformer());
        //   return $this->response->item($activity, new ActivityTransformer());
    }

    public function destroy($id)
    {

    }


}