<?php
namespace App\Etrack\Transformers\Worker;

use App\Etrack\Entities\Worker\Worker;
use League\Fractal\TransformerAbstract;

class WorkerPositionTransformer extends TransformerAbstract
{

    public function transform(Worker $model)
    {
        return [
            'name' => $model->position
        ];
    }

}