<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Entities\Activity\ActivityScheduleExecutionStatus;
use League\Fractal\TransformerAbstract;

/**
 * Class ActivityScheduleExecutionStatusTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class ActivityScheduleExecutionStatusTransformer extends TransformerAbstract
{

    /**
     * Transform the \Activity entity
     * @param ActivityScheduleExecutionStatus $model
     * @return array
     */
    public function transform(ActivityScheduleExecutionStatus $model)
    {
        return [
            'id'         => (int)$model->id,
            'name'       => $model->name,
            'slug'       => $model->slug,
            'severity'   => $model->severity,
            'created_at' => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at' => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }
}
