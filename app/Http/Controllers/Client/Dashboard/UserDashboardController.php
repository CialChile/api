<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Etrack\Entities\Activity\ActivityScheduleExecution;
use App\Etrack\Transformers\Activity\ActivityScheduleExecutionTransformer;
use App\Etrack\Transformers\Worker\WorkerTransformer;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class UserDashboardController extends Controller
{
    public function activitiesToExecute()
    {
        $user = $this->loggedInUser();
        $query = ActivityScheduleExecution::whereHas('activitySchedule', function ($q) use ($user) {
            $q->where('operator_id', $user->id);
        })->with(['activitySchedule.activity', 'status']);
        return Datatables::of($query)
            ->setTransformer(ActivityScheduleExecutionTransformer::class)
            ->make(true);
    }

    public function expiredActivities()
    {
        $user = $this->loggedInUser();
        $query = ActivityScheduleExecution::whereHas('activitySchedule', function ($q) use ($user) {
            $q->where('operator_id', $user->id);
        })->whereHas('status', function ($q) {
            $q->where('slug', 'expired');
        })->with(['activitySchedule.activity', 'status']);
        return Datatables::of($query)
            ->setTransformer(ActivityScheduleExecutionTransformer::class)
            ->make(true);
    }


    public function supervisedActivities()
    {
        $user = $this->loggedInUser();
        $query = ActivityScheduleExecution::whereHas('activitySchedule.activity', function ($q) use ($user) {
            $q->where('supervisor_id', $user->id);
        })->whereHas('status', function ($q) {
            $q->where('slug', '!=', 'canceled')->where('slug', '!=', 'approved');
        })->with(['activitySchedule.activity', 'status']);
        return Datatables::of($query)
            ->setTransformer(ActivityScheduleExecutionTransformer::class)
            ->make(true);
    }

    public function activitiesSummaryCount()
    {
        $user = $this->loggedInUser();
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $counts = ActivityScheduleExecution::select('status_id', 'activity_schedule_id', DB::raw('count(*) as total'))
            ->whereHas('status', function ($q) {
                $q->where('slug', 'scheduled')->orWhere('slug', 'next_to_execute')->orWhere('slug', 'need_approval')->orWhere('slug', 'expired');
            })
            ->where(function ($q) use ($user) {
                $q->whereHas('activitySchedule', function ($q2) use ($user) {
                    $q2->where('operator_id', $user->id);
                })->orWhereHas('activitySchedule.activity', function ($q3) use ($user) {
                    $q3->where('supervisor_id', $user->id);
                });
            })
            ->with('status')
            ->groupBy('status_id')
            ->get();

        return $counts->pluck('total', 'status.slug');
    }

    public function activitiesSummaryGraph()
    {
        $user = $this->loggedInUser();
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $executions = ActivityScheduleExecution::select('*', DB::raw('count(*) as total'))
            ->whereHas('status', function ($q) {
                $q->where('slug', '!=', 'executed')->where('slug', '!=', 'canceled')->where('slug', '!=', 'approved');
            })
            ->where(function ($q) use ($user) {
                $q->whereHas('activitySchedule', function ($q2) use ($user) {
                    $q2->where('operator_id', $user->id);
                })->orWhereHas('activitySchedule.activity', function ($q3) use ($user) {
                    $q3->where('supervisor_id', $user->id);
                });
            })
            ->with('status')
            ->groupBy('status_id')
            ->get();

        $graphData = [
            'labels'   => [],
            'datasets' => [
                [
                    'data'                 => [],
                    'backgroundColor'      => [],
                    'hoverBackgroundColor' => []
                ]
            ]
        ];
        $bg = [
            'scheduled'       => "#337ab7",
            'next_to_execute' => "#5bc0de",
            'expired'         => "#f0ad4e",
            'executed'        => "#5cb85c",
            'canceled'        => "#d81e00",
            'approved'        => "#FF6384",
            'need_approval'   => "#FFCE56"
        ];
        $executions->each(function ($data) use (&$graphData, $bg) {
            $graphData['labels'][] = $data->status->name;
            $graphData['datasets'][0]['data'][] = $data->total;
            $graphData['datasets'][0]['backgroundColor'][] = $bg[$data->status->slug];
            $graphData['datasets'][0]['hoverBackgroundColor'][] = $bg[$data->status->slug];
        });
        return $graphData;
    }

    public function summary()
    {
        $user = $this->loggedInUser();
        return $this->response->item($user->worker, new WorkerTransformer());
    }
}
