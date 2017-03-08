<?php
namespace App\Http\Controllers\Location;

class StateController
{

    public function index($country)
    {
        $states = \Countries::where('name.common', $country)->first()->states->pluck('name');
        return response()->json(['data' => $states]);

    }
}