<?php

namespace App\Http\Controllers;

use App\Models\TourpackageRequirment;
use App\Models\Property;
use Illuminate\Http\Request;

class TourpackageRequirmentController extends Controller
{
    // Show all requirements for a property
    public function index($property_id)
    {
        $requirements = TourpackageRequirment::where('property_id', $property_id)->get();
        $destination_id = Property::where('property_id', $property_id)->First()->destination_id;
        return view('tourpackages.requirements.index', compact('requirements', 'property_id','destination_id'));
    }

  

    // Store new requirement and redirect to index or show page
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|integer',
            'requirments' => 'required|string',
        ]);

        TourpackageRequirment::create($request->all());

        return redirect()->back()
                         ->with('success', 'Requirement created successfully.');
    }

   

    // Update requirement and redirect
    public function update(Request $request, $id)
    {
        $requirement = TourpackageRequirment::findOrFail($id);

        $request->validate([
            'property_id' => 'sometimes|integer',
            'requirments' => 'sometimes|string',
        ]);

        $requirement->update($request->all());

        return redirect()->back()
                         ->with('success', 'Requirement updated successfully.');
    }

    // Delete requirement and redirect to index
    public function destroy($id)
    {
        $requirement = TourpackageRequirment::findOrFail($id);
        $property_id = $requirement->property_id;
        $requirement->delete();

        return redirect()->back()
                         ->with('success', 'Requirement deleted successfully.');
    }
}
