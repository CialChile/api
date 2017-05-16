<?php
namespace App\Http\Controllers\Dates;

use App\Http\Controllers\Controller;
use Camroncade\Timezone\Timezone;

class TimezoneController extends Controller
{

    public function index()
    {
        return (new Timezone())->timezoneList;
    }
}