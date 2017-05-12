<?php
namespace App\Http\Controllers\Client\Workers;

use App\Etrack\Entities\Worker\Worker;
use App\Etrack\Transformers\Worker\WorkerSpecialtyTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkersSpecialtyController extends Controller
{

    public function search(Request $request)
    {
        $name = $request->get('name');

        $positions = Worker::inCompany()->groupBy('specialty');
        if ($name) {
            $positions->where("specialty", 'like', $name . '%');
        }


        $positions = $positions->take(10)->get(['specialty']);
        return $this->response->collection($positions, new WorkerSpecialtyTransformer());
    }
}