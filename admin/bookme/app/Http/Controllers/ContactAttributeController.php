<?php
namespace App\Http\Controllers;

use App\Models\ContactAttribute;
use Illuminate\Http\Request;

class ContactAttributeController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $contactAttributes = ContactAttribute::all();
        return view('contact-attributes.index', compact('contactAttributes'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('contact-attributes.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'attribute_name' => 'required|string',
            'value' => 'required|string',
        ]);

        ContactAttribute::create([
            'attribute_name' => $request->attribute_name,
            'value' => $request->value,
            'created_at' => now(),
        ]);

        return redirect()->route('contact-attributes.index')->with('success', 'Contact Attribute created successfully.');
    }

    // Display the specified resource.
    public function show(ContactAttribute $contactAttribute)
    {
        return view('contact-attributes.show', compact('contactAttribute'));
    }

    // Show the form for editing the specified resource.
    public function edit(ContactAttribute $contactAttribute)
    {
        return view('contact-attributes.edit', compact('contactAttribute'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $contact_id)
    {
        // Manually retrieve the ContactAttribute using the contact_id
        $contactAttribute = ContactAttribute::where('contact_id', $contact_id)->firstOrFail();
    
        $request->validate([
            'attribute_name' => 'required|string',
            'value' => 'required|string',
        ]);
    
        // Update the contact attribute with validated request data
        $contactAttribute->update([
            'attribute_name' => $request->attribute_name,
            'value' => $request->value,
        ]);
    
        return redirect()->route('contact-attributes.index')->with('success', 'Contact Attribute updated successfully.');
    }
    

    // Remove the specified resource from storage.
    public function destroy(ContactAttribute $contactAttribute)
    {
        $contactAttribute->delete();
        return redirect()->route('contact-attributes.index')->with('success', 'Contact Attribute deleted successfully.');
    }
}
