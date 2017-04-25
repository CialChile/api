<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Transformers\Company\CompanyTransformer;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Activity\ProgramType;

/**
 * Class ProgramTypeTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class ProgramTypeTransformer extends TransformerAbstract
{

    /**
     * Transform the \ProgramType entity
     * @param ProgramType $model
     *
     * @return array
     */
    public function transform(ProgramType $model)
    {
        return [
            'id'            => (int)$model->id,
            'name'          => $model->name,
            'is_inspection' => $model->is_inspection,
            'created_at'    => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at'    => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }
}
