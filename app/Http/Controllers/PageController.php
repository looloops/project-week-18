<?php

namespace App\Http\Controllers;

use App\Models\Product;


class PageController extends Controller
{
    public function homepage()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(12);

        return view('products.index', [
            'products' => $products,
        ]);
    }
}