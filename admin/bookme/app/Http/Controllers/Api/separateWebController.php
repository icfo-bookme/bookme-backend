<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyFacility;

class separateWebController extends Controller
{
    public function FoodandDescription($id)
{
    $items = PropertyFacility::where('property_id', $id)
                ->where('facility_type', 5)
                ->get(['id', 'facilty_name', 'value']); 

    return response()->json($items);
}

}
