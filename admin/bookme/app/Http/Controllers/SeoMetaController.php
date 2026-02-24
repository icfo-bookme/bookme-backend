<?php

// app/Http/Controllers/SeoMetaController.php

namespace App\Http\Controllers;

use App\Models\SeoMeta;
use Illuminate\Http\Request;

class SeoMetaController extends Controller
{
    public function index()
    { 
       $metaTags  = SeoMeta::all();
     
        return view('seo.index', compact('metaTags'));
    }

    public function create()
    {
        return view('seo.create');
    }

    public function store(Request $request)
    { 
         try {
      
        $validated = $request->validate([
            'page_slug' => 'required|unique:seo_metas',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'header_snippet' => 'nullable|string',
        ]);

        

    } catch (\Illuminate\Validation\ValidationException $e) {
        
        dd($e->errors()); // This will show the validation error messages
    }
        

        SeoMeta::create($request->all());

        return redirect()->route('seo.index')->with('success', 'SEO meta added successfully');
    }

    public function edit($id)
    {
        $seo = SeoMeta::findOrFail($id);
        return view('seo.edit', compact('seo'));
    }

    public function update(Request $request, $id)
    {
        $seo = SeoMeta::findOrFail($id);

        $request->validate([
            'page_slug' => 'required|unique:seo_metas,page_slug,' . $seo->id,
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'header_snippet' => 'nullable|string',
        ]);

        $seo->update($request->all());

        return redirect()->route('seo.index')->with('success', 'SEO meta updated successfully');
    }

    public function destroy($id)
    {
        $seo = SeoMeta::findOrFail($id);
        $seo->delete();

        return redirect()->route('seo.index')->with('success', 'SEO meta deleted successfully');
    }
}
