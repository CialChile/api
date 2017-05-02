<?php
namespace App\Http\Controllers\Client\Workers;

use App\Etrack\Entities\Worker\Worker;
use App\Etrack\Transformers\Worker\WorkerPositionTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkersPositionController extends Controller
{

    public function search(Request $request)
    {
        $name = $request->get('name');

        $positions = Worker::inCompany()->groupBy('position');
        if ($name) {
            $positions->where("position", 'like', $name . '%');
        }


        $positions = $positions->take(10)->get(['position']);
        return $this->response->collection($positions, new WorkerPositionTransformer());
    }
}