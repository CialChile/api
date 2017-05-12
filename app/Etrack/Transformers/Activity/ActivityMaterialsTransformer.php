<?php
namespace App\Etrack\Transformers\Activity;

use App\Etrack\Entities\Activity\ActivityMaterial;
use App\Etrack\Entities\Activity\ActivityProcedure;
use League\Fractal\TransformerAbstract;

class ActivityMaterialsTransformer extends TransformerAbstract
{

    public function transform(ActivityMaterial $model)
    {
        return [
            'name' => $model->name
        ];
    }

}