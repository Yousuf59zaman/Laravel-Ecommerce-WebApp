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
}
