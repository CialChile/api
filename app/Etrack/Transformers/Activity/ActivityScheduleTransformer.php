<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Entities\Activity\ActivityObservation;
use App\Etrack\Entities\Activity\ActivitySchedule;
use App\Etrack\Transformers\Asset\AssetTransformer;
use App\Etrack\Transformers\Auth\UserTransformer;
use App\Etrack\Transformers\Company\CompanyTransformer;
use App\Etrack\Transformers\Template\TemplateTransformer;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Activity\Activity;

/**
 * Class ActivityTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class ActivityScheduleTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'activity',
        'operator',
        'createdBy',
        'asset'
    ];

    /**
     * Transform the \Activity entity
     * @param ActivitySchedule $model
     *
     * @return array
     */
    public function transform(ActivitySchedule $model)
    {
        return [
            'id'                      => (int)$model->id,
            'activity_id'             => $model->activity_id,
            'operator_id'             => $model->operator_id,
            'asset_id'                => $model->asset_id,
            'program_type_slug'       => $model->program_type_slug,
            'frequency'               => $model->frequency,
            'periodicity'             => $model->periodicity,
            'days'                    => $model->days,
            'day_of_month'            => $model->day_of_month,
            'start_time'              => Carbon::parse($model->start_time),
            'estimated_duration'      => $model->estimated_duration,
            'estimated_duration_unit' => $model->estimated_duration_unit,
            'config'                  => $model->config,
            'created_at'              => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at'              => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }

    public function includeActivity(ActivitySchedule $model)
    {
        return $this->item($model->activity, new ActivityTransformer(), 'parent');
    }

    public function includeOperator(ActivitySchedule $model)
    {
        if ($model->operator) {
            return $this->item($model->operator, new UserTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeCreatedBy(ActivitySchedule $model)
    {
        if ($model->createdBy) {
            return $this->item($model->createdBy, new UserTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeAsset(ActivitySchedule $model)
    {
        if ($model->asset) {
            return $this->item($model->asset, new AssetTransformer(), 'parent');
        }

        return $this->null();
    }
}
