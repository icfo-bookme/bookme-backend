<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyUnit;

class PackageController extends Controller
{
    
public function getPackages($id)
{
    $packages = PropertyUnit::with('price', 'discount')
        ->where('property_id', $id)
        ->get()
        ->map(function ($unit) {
            $formatted = [
                "unit_id" => $unit->unit_id,
                "property_id" => $unit->property_id,
                "unit_category" => $unit->unit_category,
                "unit_no" => $unit->unit_no,
                "unit_name" => $unit->unit_name,
                "unit_type" => $unit->unit_type,
                "person_allowed" => $unit->person_allowed,
                "additionalbed" => $unit->additionalbed,
                "mainimg" => $unit->mainimg,
                "isactive" => $unit->isactive,
                "created_at" => $unit->created_at,
                "updated_at" => $unit->updated_at,
                "description" => $unit->description,
                "Validity" => $unit->Validity,
                "Max_Stay" => $unit->Max_Stay,
            ];

            // Add price and round_trip_price from first price entry if exists
            if ($unit->price && count($unit->price) > 0) {
                $formatted['price'] = $unit->price[0]->price;
                $formatted['round_trip_price'] = $unit->price[0]->round_trip_price;
            }

            // Add discount fields only if not null or 0
            if ($unit->discount) {
                if (!empty($unit->discount->discount_percent) && $unit->discount->discount_percent != 0) {
                    $formatted['discount_percent'] = $unit->discount->discount_percent;
                }

                if (!empty($unit->discount->discount_amount) && $unit->discount->discount_amount != 0) {
                    $formatted['discount_amount'] = $unit->discount->discount_amount;
                }
            }

            return $formatted;
        });

    return response()->json($packages);
}

}