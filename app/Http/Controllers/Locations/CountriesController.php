<?php
namespace App\Http\Controllers\Locations;

use App\Etrack\Transformers\Location\CountryTransformer;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{

    public function index()
    {
        $countries = \Countries::all()->pluck('name.common');
        return response()->json(['data' => $countries]);
    }

}