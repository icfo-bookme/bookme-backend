<?php

namespace App\Http\Controllers;

use App\Models\TourConsultationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourConsultationRequestAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $requests = TourConsultationRequest::whereIn('category', ['tour', 'ship'])->get();
        return view('tour_consultation_requests.index', compact('requests'));
    }
    public function showvisa()
    {
        $requests = TourConsultationRequest::where('category','visa')->get();
        return view('tour_consultation_requests.index', compact('requests'));
    }

    public function separateShip($id)
    {
        $requests = TourConsultationRequest::where('category',$id)->get();
        return view('tour_consultation_requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tour_consultation_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'additional_info' => 'nullable|string',
        ]);

        TourConsultationRequest::create($validatedData);

        return redirect()->route('tour_consultation_requests.index')->with('success', 'Request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TourConsultationRequest $tourConsultationRequest)
    {
        return view('tour_consultation_requests.show', compact('tourConsultationRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourConsultationRequest $tourConsultationRequest)
    {
        return view('tour_consultation_requests.edit', compact('tourConsultationRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourConsultationRequest $tourConsultationRequest)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'additional_info' => 'nullable|string',
            'property_name' => 'nullable|string',
        ]);

        $tourConsultationRequest->update($validatedData);

        return redirect()->back()->with('success', 'Request updated successfully.');
    }
    public function updateVerifyBy($id)
{
   
    $row = tourConsultationRequest::findOrFail($id);

    $user = Auth::user();
    $row->verified_by = $user->name;
    $row->save();

    return redirect()->back()->with('success', 'Request updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourConsultationRequest $tourConsultationRequest)
    {
        $tourConsultationRequest->delete();
        return redirect()->back()->with('success', 'Request deleted successfully.');
    }
}