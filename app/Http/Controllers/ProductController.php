<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display the public catalog page.
     */
    public function index()
    {
        // Get all products from the database
        $products = Product::latest()->get();

        // Send the $products to the 'browsecatalog' view
        return view('browsecatalog', ['products' => $products]);
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
    }
}