<?php

namespace App\Http\Controllers\Client\Activities;

use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Transformers\Activity\ProgramTypeTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramTypesController extends Controller
{
    public function __construct()
    {
        $this->module = 'client-activities-templates';

    }

    public function index()
    {
        $this->userCan(['show.client-activities-templates', 'show.admin-templates']);
        $programTypes = ProgramType::all();

        return $this->response->collection($programTypes, new ProgramTypeTransformer());
    }
}
