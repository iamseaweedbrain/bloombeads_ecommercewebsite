<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function edit(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validatedData['description'] = $request->description;
        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        unset($validatedData['image']);

        try {
            $product->update($validatedData);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update product. Please try again.')->withInput();
       }


        return redirect()->route('admin.catalog.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->delete();
        } catch (\Exception $e) {
             return redirect()->back()->with('error', 'Failed to delete product. Please try again.');
        }


        return redirect()->route('admin.catalog.index')->with('success', 'Product deleted successfully!');
    }

    public function index()
    {
        $products = Product::latest()->get(); 

        return view('admin.catalog', ['products' => $products]);
    }
    public function store(Request $request)
    {
        //Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        //Handle the file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            
            $validatedData['image_path'] = $imagePath;
        } else {
             return redirect()->back()->withErrors(['image' => 'Product image failed to upload.'])->withInput();
        }


        unset($validatedData['image']); 
        
        try {
             Product::create($validatedData);
        } catch (\Exception $e) {
             if ($imagePath) {
                 Storage::disk('public')->delete($imagePath);
             }
             return redirect()->back()->with('error', 'Failed to save product to database. Please try again.')->withInput();
        }
        return redirect()->route('admin.catalog.index')->with('success', 'Product added successfully!');
    }
}

