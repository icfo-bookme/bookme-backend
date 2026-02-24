<?php

namespace App\Http\Controllers;
use App\Models\Icon;
use App\Models\PropertySummary;
use App\Models\PropertySummaryType;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertySummaryController extends Controller
{
    public function index()
    {
        $summaries = PropertySummary::all(); // Fetch all data
        return view('property_summary.index', compact('summaries'));
    }
    public function store(Request $request)
{ 
    $data = $request->validate([
        'property_id' => 'required|numeric',
        
        'name' => 'nullable|array',
        'name.*' => 'nullable|string',

        'value' => 'nullable|array',
        'value.*' => 'nullable|string',

        'icon' => 'nullable|array',
        'icon.*' => 'nullable|string',

        'display' => 'required|array',
        'display.*' => 'required|in:yes,no',
    ]);

    foreach ($data['value'] as $key => $value) {
        $summary = new PropertySummary();
        $summary->property_id = $data['property_id'];
        $summary->value = $value;
        $summary->name = $data['name'][$key] ?? null; // Optional
        $summary->icon = $data['icon'][$key] ?? null; // Optional
        $summary->display = $data['display'][$key];   // Required

        $summary->save();
    }

    return redirect()->back()->with('success', 'Summaries added successfully.');
}


public function show($property_id)
{
    
    $property = Property::findOrFail($property_id);  
    $summaries = PropertySummary::where('property_id', $property_id)->get(); 
     $names = PropertySummaryType::where('service_category_id', $property->category_id)->get(); 
    $icons = Icon::all();
    $category_id = $property->category_id;
   if($property->category_id==7){
       return view('CarRental.property-summary.show', compact('property', 'summaries', 'property_id', 'icons', 'names', 'category_id'));
   }
    if($property->category_id==6){
       return view('activities.property-summary.show', compact('property', 'summaries', 'property_id', 'icons','names', 'category_id'));
   }
    return view('property-summary.show', compact('property', 'summaries', 'property_id', 'icons' , 'category_id'));
}
public function showvisa($property_id)
{
    
    $property = Property::findOrFail($property_id);  
    $summaries = PropertySummary::where('property_id', $property_id)->get();  
    $icons = Icon::all();
   
    return view('visa.property-summary.show', compact('property', 'summaries', 'property_id', 'icons'));
}

public function update(Request $request, $id)
{ 
    // Find the summary by its ID
    $summary = PropertySummary::find($id);

    if ($summary) {
        // Update the summary with the new data
        $summary->value = $request->input('value');
        $summary->icon = $request->input('icon');
        $summary->name = $request->input('name');
        $summary->display = $request->input('display');

        $summary->save();

        return redirect()->back();
    }

    return redirect()->back()->with('error', 'Summary not found.');
}

public function destroy($id)
{
    $summary = PropertySummary::find($id);
    if ($summary) {    
        $summary->delete(); 
        return redirect()->back();
    }
  
    return redirect()->route('property-summary.index')->with('error', 'Summary not found.');
}

}

