<?php
namespace App\Etrack\Transformers\Activity;

use App\Etrack\Entities\Activity\ActivityProcedure;
use League\Fractal\TransformerAbstract;

class ActivityProceduresTransformer extends TransformerAbstract
{

    public function transform(ActivityProcedure $model)
    {
        return [
            'type'           => [
                'name' => $model->name,
                'slug' => $model->type
            ],
            'definitionList' => $model->definition
        ];
    }

}