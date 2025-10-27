<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // <-- Import the Product model

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
}