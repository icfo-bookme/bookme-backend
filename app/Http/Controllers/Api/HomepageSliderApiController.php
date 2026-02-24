<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomepageSlider;
use App\Models\Spot;
use App\Models\ServiceCategory;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class HomepageSliderApiController extends Controller
{
    
    public function index()
    {
        $sliders = HomepageSlider::all();

        return response()->json([
            'success' => true,
            'data' => $sliders
        ]);
    }

    
    public function destinations()
    {
        $sliders = Spot::where('category', 'destination')->get();

        return response()->json([
            'success' => true,
            'data' => $sliders
        ]);
    }

    
    public function PropertyImages()
    {
        $sliders = Image::first();

        return response()->json($sliders);
    }

   
    public function services()
    {
       
        $services = DB::table('service_category')
            ->select('category_name', 'isShow', 'serialno')
            ;

        $tours = DB::table('destinations')
            ->select(DB::raw('name as category_name'), 'isShow', 'serialno')
           ;

        $combined = $services->union($tours)->get();

        return response()->json([
            'success' => true,
            'data' => $combined
        ]);
    }
}
