<?php
namespace App\Etrack\Transformers\Worker;

use App\Etrack\Entities\Worker\Worker;
use League\Fractal\TransformerAbstract;

class WorkerSpecialtyTransformer extends TransformerAbstract
{

    public function transform(Worker $model)
    {
        return [
            'name' => $model->specialty
        ];
    }

}