<?php
namespace App\Http\Controllers\Client\Activities;

use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Transformers\Activity\ProgramTypeTransformer;
use App\Http\Controllers\Controller;

class ActivitiesController extends Controller
{

    public function __construct()
    {
        $this->module = 'client-activities-templates';

    }

}