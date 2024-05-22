<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(12);
        return view('products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->all();
        /*  dd($data); */
        $newProduct = new Product();
        $newProduct->name = $data['name'];
        $newProduct->description = $data['description'];
        $newProduct->brand = $data['brand'];
        $newProduct->price = $data['price'];
        $newProduct->img = $data['img'];
        $newProduct->user_id = $request->user()->id;
        $newProduct->save();

        //Reindirizzamento all'index
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (Auth::user()->id !== $product->user_id)
            abort(401);
        return view('products.edit', compact('product'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if (Auth::user()->id !== $product->user_id)
            abort(401);
        $data = $request->all();

        $product->name = $data['name'];
        $product->brand = $data['brand'];
        $product->price = $data['price'];
        $product->img = $data['img'];
        $product->update();


        return redirect()->route('products.show', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (Auth::user()->id !== $product->user_id)
            abort(401);
        $product->delete();
        return redirect()->route('products.index');
    }
}
