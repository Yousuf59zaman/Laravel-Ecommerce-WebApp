<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class CartController extends Controller
{
    /**
     * The index function is responsible for displaying the cart items.
     * It retrieves the cart items from the session and passes it to the
     * 'cart.index' view. If the cart is not present in the session,
     * it defaults to an empty array.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Retrieve the cart items from the session
        // If the cart does not exist in the session, it defaults to an empty array
        $cart = session()->get('cart', []);
        
        // Pass the cart items to the 'cart.index' view
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        // Retrieve the cart items from the session.
        // If the cart does not exist in the session, it defaults to an empty array.
        $cart = session()->get('cart', []);
        
        // Retrieve the 'quantity' parameter from the request.
        // If the 'quantity' parameter is not present in the request, it defaults to 1.
        $quantity = $request->quantity ?? 1;
        
        // Check if the cart already contains the product with id $product->id.
        // If it does, increase the quantity of the product by the value of $quantity.
        // Otherwise, add the product to the cart with the specified quantity, price, and image.
        if (isset($cart[$product->id])) {
            // Increase the quantity of the product in the cart.
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // Add the product to the cart.
            // The product details are the name, quantity, price, and image of the product.
            $cart[$product->id] = [
                "name" => $product->name, // The name of the product.
                "quantity" => $quantity, // The quantity of the product to be added to the cart.
                "price" => $product->price, // The price of the product.
                "image" => $product->image // The image of the product.
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }


    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully!');
        }
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        // Calculate the total price of the cart
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.checkout', compact('cart', 'total'));
    }
    
}
