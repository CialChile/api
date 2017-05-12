<?php
namespace App\Http\Controllers\Client\Activities;

use App\Etrack\Entities\Activity\Activity;
use App\Etrack\Entities\Activity\ActivityMaterial;
use App\Etrack\Entities\Activity\ActivityObservation;
use App\Etrack\Entities\Activity\ActivityProcedure;
use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Transformers\Activity\ActivityTransformer;
use App\Etrack\Transformers\Asset\AssetTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityStoreRequest;
use App\Http\Requests\Activity\ActivityUpdateRequest;
use Datatables;
use DB;
use Dingo\Api\Http\Request;

class ActivitiesAssetsController extends Controller
{

    public function __construct()
    {
        $this->module = 'client-activities-activities';

    }

    public function datatable(Request $request, $activityId)
    {
        $this->userCan('list');
        $except = $request->has('except') ? explode(',', $request->get('except')) : [];

        $activity = Activity::inCompany()->find($activityId);
        if (!$activity) {
            return $this->response->errorForbidden('No tienes permiso para ver estos activos');
        }
        $query = $activity->assets();
        $query = count($except) ? $query->whereNotIn('assets.id', $except) : $query;
        return Datatables::of($query)
            ->setTransformer(AssetTransformer::class)
            ->make(true);
    }

    public function search(Request $request, $activityId)
    {
        $name = $request->get('name');
        $initialAssetId = $request->get('initialAssetId');
        $activity = Activity::inCompany()->find($activityId);
        if (!$activity) {
            return $this->response->errorForbidden('No tienes permiso para ver estos activos');
        }
        $query = $activity->assets()->whereDoesntHave('schedules', function ($q) use ($activity) {
            $q->where('activity_id', $activity->id);
        })->orWhereHas('schedules', function ($q) use ($activity, $initialAssetId) {
            $q->where('activity_id', $activity->id)->where('asset_id', $initialAssetId);
        });

        if ($name) {
            $query = $query->where("name", 'like', $name);
        }
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $assets = $query->groupBy('id')->take(10)->get();
        return $this->response->collection($assets, new AssetTransformer());
    }

}