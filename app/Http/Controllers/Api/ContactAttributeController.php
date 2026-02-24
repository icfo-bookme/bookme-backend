<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactAttributeController extends Controller
{
    // Display a listing of the resource
   public function index()
{
    // Fetch all contact attributes from the database
    $contactAttributes = ContactAttribute::all();

    // Transform the data to the desired format (attribute_name => value)
    $transformedAttributes = $contactAttributes->mapWithKeys(function ($contactAttribute) {
        return [$contactAttribute->attribute_name => $contactAttribute->value];
    });

    // Return the transformed data as a JSON response
    return response()->json($transformedAttributes);
}

   
   
}
