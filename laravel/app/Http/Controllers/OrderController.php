<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{

    // public function index()
    // {
    //     $orders = Order::where('user_id', Auth::id())->paginate(10);
    //     dd($orders); // Dump and die to check the variable type
    //     return view('orders.index', compact('orders'));
    // }


    public function orderhistory()
{
    // Retrieve all orders associated with the authenticated user
    $orders = Order::where('user_id', Auth::id())->paginate(10);
    // Check if the authenticated user is an admin
    if (Auth::user()->is_admin == 1) {
        return redirect()->route('orders.indexAll');
    }
    //dd($orders); // Dump and die to check the variable type
    return view('orders.index', compact('orders'));
}


public function showDetails(Order $order)
{
    // This retrieves all order details linked to the specific order
    $orderDetails = $order->orderDetails()->with('product')->get();
    return view('orders.showDetails', compact('order', 'orderDetails'));
}

    
    // OrderController.php


public function processCheckout(Request $request)
{
    // Retrieve cart data from the request or session
    $cart = $request->session()->get('cart', []);

    // Calculate the total price of the cart
    $total = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $cart));

    // Create a new order with the total price and user_id
    $order = Order::create([
        'user_id' => Auth::id(),
        'total' => $total,
        'status' => 'pending'
    ]);

    // Insert each cart item as an order detail
    foreach ($cart as $id => $details) {
        OrderDetail::create([
            'order_id' => $order->order_id,
            'product_id' => $id,
            'quantity' => $details['quantity'],
            'price' => $details['price']
        ]);
    }

    // Clear the cart session after checkout
    $request->session()->forget('cart');

    // Redirect to the order placed page with a success message
    return redirect()->route('order.placed')->with('success', 'Order placed successfully!');
}
    

    public function indexAll()
    {
        $orders = Order::all();
        return view('admin.manageorders', compact('orders'));
    }

    public function updateStatus(Order $order)
{
    $order->status = 'completed';
    $order->save();

    return redirect()->route('orders.indexAll')->with('success', 'Order status updated successfully.');
}

}
