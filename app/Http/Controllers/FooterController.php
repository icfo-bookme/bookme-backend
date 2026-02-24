<?php
namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        return response()->json(Footer::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'terms' => 'required|string',
            'talent_and_culture' => 'required|string',
            'refund_policy' => 'required|string',
            'emi_policy' => 'required|string',
            'privacy_policy' => 'required|string',
        ]);

        $footer = Footer::create($request->all());

        return response()->json($footer, 201);
    }

    public function show(Footer $footer)
    {
        return response()->json($footer, 200);
    }

    public function update(Request $request, Footer $footer)
    {
        $request->validate([
            'terms' => 'string',
            'talent_and_culture' => 'string',
            'refund_policy' => 'string',
            'emi_policy' => 'string',
            'privacy_policy' => 'string',
        ]);

        $footer->update($request->all());

        return response()->json($footer, 200);
    }

    public function destroy(Footer $footer)
    {
        $footer->delete();
        return response()->json(['message' => 'Footer deleted successfully'], 200);
    }
}
