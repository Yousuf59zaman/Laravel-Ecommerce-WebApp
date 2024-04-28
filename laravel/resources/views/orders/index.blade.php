<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <title>Order History</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Your Orders</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                    <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-info">View Details</a>
                    
                 </td>
                 </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ url('/') }}" style="margin-top:2rem;">
                <button type="submit" class="btn btn-danger">Cancel</button>
        </a>
    </div>
    
      <!-- bootstrap js and popper js -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
</body>
</html>
