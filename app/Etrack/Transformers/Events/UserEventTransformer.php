<?php
namespace App\Etrack\Transformers\Events;

use App\Etrack\Entities\Activity\ActivityScheduleExecution;
use App\Etrack\Services\Activities\Schedules\ScheduleExecutionService;
use League\Fractal\TransformerAbstract;

class UserEventTransformer extends TransformerAbstract
{

    public function transform(ActivityScheduleExecution $model)
    {
        $service = new ScheduleExecutionService();
        $user = \Auth::user();
        $end = $service->scheduleEnd($model->execution_date, $model->activitySchedule->estimated_duration, $model->activitySchedule->estimated_duration_unit);
        $start = $model->execution_date->timezone($user->timezone);
        $end = $end->timezone($user->timezone);
        $bgColor = [
            'info'    => '#5bc0de',
            'warning' => '#f0ad4e',
            'danger'  => '#d81e00',
            'success' => '#5cb85c',
        ];
        return [
            'id'              => $model->id,
            'title'           => $model->activitySchedule->activity->name . ' (' . $model->status->name . ')',
            'start'           => $start->toW3cString(),
            'end'             => $end->toW3cString(),
            'backgroundColor' => $bgColor[$model->status->severity],
            'borderColor'     => $bgColor[$model->status->severity],
        ];
    }
}