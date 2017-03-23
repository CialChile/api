<?php
namespace App\Http\Controllers\Locations;

class StatesController
{

    public function index($country)
    {
        $states = \Countries::where('name.common', $country)->first()->states->pluck('name');
        return response()->json(['data' => $states]);

    }
}