<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
     // Display a listing of the products
     public function index()
     {
         $products = Product::all();
         return view('home', compact('products'));
     }
      
     public function adminIndex()
     {
    $products = Product::all();
    return view('admin.product', compact('products')); // Redirect to the admin products view
     }

     public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function create()
{
    return view('admin.addproduct');
}

public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|image|max:2048', // 2MB Max
    ]);

    $data['image'] = $request->file('image')->store('public/images');

    Product::create($data);

    return redirect()->route('products.index')->with('success', 'Product added successfully!');
}
public function edit(Product $product)
{
    return view('admin.editproduct', compact('product'));
}

public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'sometimes|image|max:2048', // Image is optional
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('public/images');
    }

    $product->update($data);

    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}


public function destroy(Product $product)
{
    // Delete the product
    $product->delete();

    // Redirect back to the product list with a success message
    return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
}

     
}
