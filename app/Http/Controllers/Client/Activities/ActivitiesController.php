<?php
namespace App\Http\Controllers\Client\Activities;

use App\Etrack\Entities\Activity\Activity;
use App\Etrack\Entities\Activity\ActivityMaterial;
use App\Etrack\Entities\Activity\ActivityObservation;
use App\Etrack\Entities\Activity\ActivityProcedure;
use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Transformers\Activity\ActivityTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityStoreRequest;
use App\Http\Requests\Activity\ActivityUpdateRequest;
use Datatables;
use DB;

class ActivitiesController extends Controller
{

    public function __construct()
    {
        $this->module = 'client-activities-activities';

    }

    public function index()
    {

    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Activity::inCompany()->with(['programType', 'template']))
            ->setTransformer(ActivityTransformer::class)
            ->make(true);
    }

    public function show($id)
    {
        $this->userCan('show');
        $activity = Activity::inCompany()->find($id);
        if (!$activity) {
            $this->response->errorForbidden('No tienes permiso para ver esta actividad');
        }

        return $this->response->item($activity, new ActivityTransformer());
    }

    public function store(ActivityStoreRequest $request)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $activityData = $request->only(['name', 'description', 'program_type_id', 'template_id']);
        $supervisorData = $request->only(['supervisor']);
        $equipmentData = $request->only(['equipment']);
        $proceduresData = $request->only(['procedures']);
        $observations = $request->only(['observations']);
        $assets = $request->only(['assets']);
        DB::beginTransaction();
        $programType = ProgramType::find($activityData['program_type_id']);
        $activityData['creator_id'] = $user->id;
        $activityData['company_id'] = $user->company_id;
        $activity = new Activity();
        $activity->fill($activityData);
        $activity->save();

        if ($supervisorData['supervisor']) {
            $supervisor = User::inCompany()->find($supervisorData['supervisor']['id']);
            if (!$supervisor) {
                return $this->response->errorForbidden('No puede asignar este supervisor a la actividad, permiso denegado.');
            }
            $activity->supervisor()->associate($supervisor);
            $activity->save();
        }

        if ($equipmentData) {
            $materials = collect($equipmentData['equipment']['equipmentList']);
            $materials->each(function ($material) use ($activity) {
                $materialDb = new ActivityMaterial($material);
                $activity->materials()->save($materialDb);
            });
        }

        if ($proceduresData) {
            $procedures = collect($proceduresData['procedures']['procedureList']);
            $procedures->each(function ($procedure) use ($activity) {
                $procedure['definition'] = $procedure['definitionList'];
                $procedure['name'] = $procedure['type']['name'];
                $procedure['type'] = $procedure['type']['slug'];
                unset($procedure['definitionList']);
                $procedureDb = new ActivityProcedure($procedure);
                $activity->procedures()->save($procedureDb);
            });
        }

        if ($observations) {
            $observations = collect($observations['observations']);
            $observations->each(function ($observation) use ($activity) {
                $observationDb = new ActivityObservation($observation);
                $activity->observations()->save($observationDb);
            });
        }

        if ($programType->has_assets) {
            if (!$assets) {
                return $this->response->errorBadRequest('Debe añadir uno o más activos a la actividad');
            }

            $assets = collect($assets['assets']);
            $assetsIds = $assets->pluck('id');
            $activity->assets()->sync($assetsIds);
        }
        DB::commit();
        return $this->response->item($activity, new ActivityTransformer());
    }

    public function update(ActivityUpdateRequest $request, $id)
    {
        $this->userCan('update');
        $user = $this->loggedInUser();
        $activityData = $request->only(['name', 'description', 'program_type_id', 'template_id']);
        $supervisorData = $request->only(['supervisor']);
        $equipmentData = $request->only(['equipment']);
        $proceduresData = $request->only(['procedures']);
        $assets = $request->only(['assets']);
        /** @var Activity $activity */
        $activity = Activity::inCompany()->find($id);
        $observations = $request->only(['observations']);

        if (!$activity) {
            return $this->response->errorForbidden('No tiene permiso para modificar esta actividad');
        }
        DB::beginTransaction();
        $programType = ProgramType::find($activityData['program_type_id']);
        $activityData['company_id'] = $user->company_id;
        $activity->fill($activityData);
        $activity->save();

        if ($supervisorData['supervisor']) {
            $supervisor = User::inCompany()->find($supervisorData['supervisor']['id']);
            if (!$supervisor) {
                return $this->response->errorForbidden('No puede asignar este supervisor a la actividad, permiso denegado.');
            }
            $activity->supervisor()->associate($supervisor);
            $activity->save();
        } else {
            $activity->supervisor_id = null;
            $activity->save();
        }
        $activity->materials()->delete();
        $activity->procedures()->delete();
        $activity->observations()->delete();
        $activity->assets()->detach();
        if ($equipmentData) {
            $materials = collect($equipmentData['equipment']['equipmentList']);
            $materials->each(function ($material) use ($activity) {
                $materialDb = new ActivityMaterial($material);
                $activity->materials()->save($materialDb);
            });
        }

        if ($proceduresData) {
            $procedures = collect($proceduresData['procedures']['procedureList']);
            $procedures->each(function ($procedure) use ($activity) {
                $procedure['definition'] = $procedure['definitionList'];
                $procedure['name'] = $procedure['type']['name'];
                $procedure['type'] = $procedure['type']['slug'];
                unset($procedure['definitionList']);
                $procedureDb = new ActivityProcedure($procedure);
                $activity->procedures()->save($procedureDb);
            });
        }

        if ($observations) {
            $observations = collect($observations['observations']);
            $observations->each(function ($observation) use ($activity) {
                $observationDb = new ActivityObservation($observation);
                $activity->observations()->save($observationDb);
            });
        }

        if ($programType->has_assets) {
            if (!$assets) {
                return $this->response->errorBadRequest('Debe añadir uno o más activos a la actividad');
            }
            $assets = collect($assets['assets']);
            $assetsIds = $assets->pluck('id');
            $activity->assets()->sync($assetsIds);
        }
        DB::commit();
        return $this->response->item($activity, new ActivityTransformer());
    }

    public function destroy($id)
    {

    }


}