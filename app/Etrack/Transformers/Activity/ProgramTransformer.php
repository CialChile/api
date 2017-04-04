<?php

namespace App\Etrack\Transformers\Activity;

use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Activity\Program;

/**
 * Class ProgramTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class ProgramTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'frequency',
        'periodicity'
    ];
    /**
     * Transform the \Program entity
     * @param Program $model
     *
     * @return array
     */
    public function transform(Program $model)
    {
        return [
            'id'             => (int) $model->id,
            'frequency_id'   => $model->frequency_id,
            'periodicity_id' => $model->periodicity_id,
            'name'           => $model->name,
            'created_at'     => $model->created_at,
            'updated_at'     => $model->updated_at
        ];
    }

    public function includeFrequency(Program $model)
    {
        return $this->item($model->frequency, new FrequencyTransformer(), 'parent');
    }

    public function includePeriodicity(Program $model)
    {
        return $this->item($model->periodicity, new PeriodicityTransformer(), 'parent');
    }
}
