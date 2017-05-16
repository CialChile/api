<?php
namespace App\Http\Controllers\Client\Activities;

use App\Etrack\Entities\Activity\Activity;
use App\Etrack\Entities\Activity\ActivityMaterial;
use App\Etrack\Entities\Activity\ActivityObservation;
use App\Etrack\Entities\Activity\ActivityProcedure;
use App\Etrack\Entities\Activity\ActivitySchedule;
use App\Etrack\Entities\Activity\ActivityScheduleExecution;
use App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus;
use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Services\Activities\Schedules\ScheduleExecutionService;
use App\Etrack\Transformers\Activity\ActivityScheduleTransformer;
use App\Etrack\Transformers\Activity\ActivityTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityScheduleStoreRequest;
use App\Http\Requests\Activity\ActivityScheduleUpdateRequest;
use App\Http\Requests\Activity\ActivityStoreRequest;
use App\Http\Requests\Activity\ActivityUpdateRequest;
use App\Notifications\Client\Activities\Operators\ScheduleAboutToExecute;
use App\Notifications\Client\Activities\Operators\ScheduleCreated;
use Carbon\Carbon;
use Datatables;
use DB;

class ActivitiesSchedulesController extends Controller
{

    /**
     * @var ScheduleExecutionService
     */
    private $scheduleExecutionService;

    public function __construct(ScheduleExecutionService $scheduleExecutionService)
    {
        $this->module = 'client-activities-schedules';

        $this->scheduleExecutionService = $scheduleExecutionService;
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
        $assetsIDs = $assets->pluck('id');
        $this->validateActivityInCompany($activity);
        $this->validateAssetsWereNotScheduled($activity, $assetsIDs);
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
        $schedule->day_of_month = $program['dayOfMonth'] ?: 0;
        $schedule->config = $program;
        /** @var User $operator */
        $operator = User::find($operatorId);
        $assets->each(function ($asset) use ($schedule, $activity, $operator) {
            $newSchedule = $schedule->replicate();
            $newSchedule->asset()->associate($asset['id']);
            $schedule = $activity->schedules()->save($newSchedule);
            $this->createExecution($schedule, $operator);
        });

        if ($assets->isEmpty()) {
            $schedule = $activity->schedules()->save($schedule);
            $this->createExecution($schedule, $operator);
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
        $assetsIDs = collect([$asset['id']]);
        $this->validateActivityInCompany($activity);
        /** @var ActivitySchedule $schedule */
        $schedule = $activity->schedules()->find($id);
        if (!$schedule) {
            $this->response->errorForbidden('No se encontró la programación en nuestros registros');
        }

        if ($schedule->asset_id !== (int)$asset['id']) {
            $this->validateAssetsWereNotScheduled($activity, $assetsIDs);
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

    /**
     * @param $schedule
     * @param $operator
     */
    function createExecution(ActivitySchedule $schedule, User $operator)
    {
        $executionDate = $this->scheduleExecutionService->nextExecutionDate($schedule->config, false);
        $daysDifference = Carbon::now()->diffInDays($executionDate);
        $statusSlug = $daysDifference < 3 ? 'next_to_execute' : 'scheduled';
        $status = ActivityScheduleExecutionStatus::where('slug', $statusSlug)->first();
        $execution = new ActivityScheduleExecution();
        $execution->execution_date = $executionDate;
        $execution->status_id = $status->id;
        $execution = $schedule->executions()->save($execution);
        $operator->notify(new ScheduleCreated($execution));
        if ($daysDifference < 3) {
            $operator->notify(new ScheduleAboutToExecute($execution));
        }
    }

    /**
     * @param $activity
     * @param $assetsIDs
     */
    private function validateAssetsWereNotScheduled($activity, $assetsIDs, $currentAsset = null)
    {
        $scheduleWithDuplicateAssets = $activity->schedules()->with('asset')->whereIn('asset_id', $assetsIDs->toArray())->get();
        if ($scheduleWithDuplicateAssets->count()) {
            if (count($scheduleWithDuplicateAssets) == 1) {
                $this->response->errorForbidden('No se puede crear la programación del activo: ' . $scheduleWithDuplicateAssets->first()->asset->name . ' pues ya tiene una programación asociada');
            }

            $message = '';
            $scheduleWithDuplicateAssets->each(function ($schedule) use (&$message) {
                $message .= $schedule->asset->name . ', ';
            });

            $message = substr($message, 0, strlen($message) - 2);
            $this->response->errorForbidden('No se puede crear la programación de los activos: ' . $message . ' pues ya tienen programaciones asociadas');
        }
    }

    /**
     * @param $activity
     */
    private function validateActivityInCompany($activity)
    {
        if (!$activity) {
            $this->response->errorForbidden('No tienes permiso para generar programaciones a la actividad');
        }
    }
}