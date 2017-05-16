<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Entities\Activity\ActivityScheduleExecutionObservation;
use League\Fractal\TransformerAbstract;

/**
 * Class ActivityScheduleExecutionObservationTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class ActivityScheduleExecutionObservationTransformer extends TransformerAbstract
{

    /**
     * Transform the \Activity entity
     * @param ActivityScheduleExecutionObservation $model
     * @return array
     */
    public function transform(ActivityScheduleExecutionObservation $model)
    {
        return [
            'id'                             => (int)$model->id,
            'activity_schedule_execution_id' => $model->activity_schedule_execution_id,
            'observation'                    => $model->observation,
            'created_at'                     => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at'                     => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }
}
