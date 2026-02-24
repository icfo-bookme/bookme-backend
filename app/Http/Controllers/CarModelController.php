<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarModelController extends Controller
{
    public function index($id)
    {
        $carModels = CarModel::with('brand')->where('brand_id', $id)->orderBy('id', 'desc')->get();
        $carBrands = CarBrand::orderBy('name')->get();
        return view('CarRental.car_models.index', compact('carModels', 'carBrands'));
    }

    public function getModels($brand_id)
    {
        $models = CarModel::where('brand_id', $brand_id)->pluck('model_name', 'id');
        return response()->json($models);
    }

    public function create()
    {
        $brands = CarBrand::orderBy('name')->get();
        return view('car_models.create', compact('brands'));
    }

    public function store(Request $request)
    { 
        $request->validate([
            'brand_id' => 'required|exists:car_brand,id',
            'model_name' => 'required|max:100',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
        ]);

        $exists = CarModel::where('brand_id', $request->brand_id)
            ->where('model_name', $request->model_name)
            ->exists();

        if ($exists) {
            return back()->withErrors(['model_name' => 'This model already exists for the selected brand'])->withInput();
        }

        $data = $request->only('brand_id', 'model_name', 'status');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('car_models', 'public');
        }

        CarModel::create($data);

        return redirect()->back()->with('success', 'Car model created successfully.');
    }

    public function edit(CarModel $carModel)
    {
        $brands = CarBrand::orderBy('name')->get();
        return view('car_models.edit', compact('carModel', 'brands'));
    }

  public function update(Request $request, $id)
{
    // Retrieve the CarModel manually
    $carModel = CarModel::findOrFail($id);

    try {
        $validated = $request->validate([
            'brand_id' => 'required|exists:car_brand,id',
            'model_name' => 'required|max:100',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        dd($e->errors()); // Show validation errors if any
    }

    // Check for duplicates
    $exists = CarModel::where('brand_id', $request->brand_id)
        ->where('model_name', $request->model_name)
        ->where('id', '!=', $id)
        ->exists();

    if ($exists) {
        return back()->withErrors(['model_name' => 'This model already exists for the selected brand'])->withInput();
    }

    $data = $request->only('brand_id', 'model_name', 'status');

    // Handle image upload
    if ($request->hasFile('image')) {
        if ($carModel->image && Storage::disk('public')->exists($carModel->image)) {
            Storage::disk('public')->delete($carModel->image);
        }

        $data['image'] = $request->file('image')->store('car_models', 'public');
    }

    // Update the model manually
    $carModel->update($data);

    return redirect()->back()->with('success', 'Car model updated successfully.');
}


    public function destroy($id)
    { 
        // Delete image from storage
        $carModel = CarModel::find($id);
        
        if ($carModel->image && Storage::disk('public')->exists($carModel->image)) {
            Storage::disk('public')->delete($carModel->image);
        }

        $carModel->delete();
        return redirect()->back()->with('success', 'Car model deleted successfully.');
    }
}
