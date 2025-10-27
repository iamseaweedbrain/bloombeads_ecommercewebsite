<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Example cart items
        $cartItems = [
            [
                'name' => 'Beautiful Bead 1',
                'quantity' => 2,
                'price' => 10.00,
                'image' => 'catalog-assets/jjkBagcharm.jpeg',
            ],
            [
                'name' => 'Beautiful Bead 2',
                'quantity' => 1,
                'price' => 15.00,
                'image' => 'catalog-assets/jjkBagcharm2.jpeg',
            ]
        ];        
        return view('cart', compact('cartItems'));
    }
}