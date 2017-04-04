<?php

namespace App\Etrack\Transformers\Template;

use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Template\MeasureUnit;

/**
 * Class MeasureUnitTransformer
 * @package namespace App\Etrack\Transformers\Template;
 */
class MeasureUnitTransformer extends TransformerAbstract
{

    /**
     * Transform the \MeasureUnit entity
     * @param MeasureUnit $model
     *
     * @return array
     */
    public function transform(MeasureUnit $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
