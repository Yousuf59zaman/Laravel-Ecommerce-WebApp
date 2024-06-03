<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Order Details</title>
</head>
<body>
<div class="container mt-5">
    <h2>Order Details for Order #{{ $order->order_id }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price Per Item</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product ? $detail->product->name : 'Product Deleted' }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>${{ number_format($detail->price, 2) }}</td>
                    <td>${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No details found for this order.</td></tr>
            @endforelse
            <tr>
                <td>Total</td>
                <td></td>
                <td></td>
                <td>${{ number_format($order->total, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('orderhistory') }}" class="btn btn-secondary">Back to Orders</a>
</div>




      <!-- bootstrap js and popper js -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
</body>
</html>
