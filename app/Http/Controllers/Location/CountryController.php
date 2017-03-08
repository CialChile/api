<?php
namespace App\Http\Controllers\Location;

use App\Etrack\Transformers\Location\CountryTransformer;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{

    public function index()
    {
        $countries = \Countries::all()->pluck('name.common');
        return response()->json(['data' => $countries]);
    }

}