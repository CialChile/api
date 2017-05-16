<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Entities\Activity\ActivityScheduleExecution;
use App\Etrack\Transformers\Auth\UserTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class ActivityScheduleExecutionTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class ActivityScheduleExecutionTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'observations',
        'executedBy',
        'activitySchedule',
        'status',
    ];

    /**
     * Transform the \Activity entity
     * @param ActivityScheduleExecution $model
     * @return array
     */
    public function transform(ActivityScheduleExecution $model)
    {
        $user = \Auth::user();
        $executionDate = null;
        if ($model->execution_date) {
            $executionDate = $model->execution_date;
            $executionDate->timezone($user->timezone);
            $executionDate = $executionDate->format('d/m/Y h:i A');
        }

        $executedDate = null;
        if ($model->executed_date) {
            $executedDate = $model->executed_date;
            $executedDate->timezone($user->timezone);
            $executedDate = $executedDate->format('d/m/Y h:i A');
        }

        return [
            'id'                   => (int)$model->id,
            'activity_schedule_id' => $model->activity_schedule_id,
            'executed_by'          => $model->executed_by,
            'status_id'            => $model->status_id,
            'executed_date'        => $executedDate,
            'execution_date'       => $executionDate,
            'duration'             => $model->duration,
            'duration_unit'        => $model->duration_unit,
            'executed'             => $model->executed,
            'created_at'           => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at'           => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }

    public function includeObservations(ActivityScheduleExecution $model)
    {
        if ($model->observations) {
            return $this->collection($model->observations, new ActivityScheduleExecutionObservationTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeExecutedBy(ActivityScheduleExecution $model)
    {
        if ($model->executedBy) {
            return $this->item($model->executedBy, new UserTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeActivitySchedule(ActivityScheduleExecution $model)
    {
        return $this->item($model->activitySchedule, new ActivityScheduleTransformer(), 'parent');

    }

    public function includeStatus(ActivityScheduleExecution $model)
    {
        return $this->item($model->status, new ActivityScheduleExecutionStatusTransformer(), 'parent');
    }
}
