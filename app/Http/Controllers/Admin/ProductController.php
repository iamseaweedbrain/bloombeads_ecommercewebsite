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
        // Return product data as JSON for the JavaScript function
        return response()->json($product);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
            // Delete the associated image file first
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            // Delete the product record
            $product->delete();
        } catch (\Exception $e) {
             // Log the error $e->getMessage()
             return redirect()->back()->with('error', 'Failed to delete product. Please try again.');
        }


        return redirect()->route('admin.catalog.index')->with('success', 'Product deleted successfully!');
    }

    /**
     */
    public function index()
    {
        // Get all products from the database, ordered by newest first
        $products = Product::latest()->get(); 

        // Send the $products variable to the admin.catalog view
        return view('admin.catalog', ['products' => $products]);
    }

    /**
     * Store a new product in the database.
     */
    public function store(Request $request)
    {
        //Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        //Handle the file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            
            $validatedData['image_path'] = $imagePath;
        } else {
             return redirect()->back()->withErrors(['image' => 'Product image failed to upload.'])->withInput();
        }


        //Create the product in the database
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

