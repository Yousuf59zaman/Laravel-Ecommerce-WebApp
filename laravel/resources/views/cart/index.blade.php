<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Shopping Cart</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Shopping Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                </tr>
            </thead><tbody>
    @if(session('cart'))
        <!-- If the 'cart' session data exists -->
        @foreach(session('cart') as $id => $details)
            <!-- Loop through each item in the cart -->
            <tr>
                <td>
                    <!-- Display product image and name -->
                    <img src="{{ asset($details['image']) }}" width="100" height="100" class="img-responsive"/>
                    {{ $details['name'] }}
                </td>
                <td>
                    <!-- Display product price -->
                    ${{ $details['price'] }}
                </td>
                <td>
                    <!-- Form to update quantity -->
                    <form action="{{ route('cart.update', $id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" max="10">
                        <button type="submit" class="btn btn-info btn-sm">Update</button>
                    </form>
                </td>
                <td>
                    <!-- Form to remove item from cart -->
                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
        @endforeach
    @else
        <!-- If the cart is empty -->
        <tr>
            <td colspan="4" class="text-center">Your cart is empty</td>
        </tr>
    @endif
</tbody>

        </table>
    </div>


    <div class="container mt-5">
        <a href="{{ url('') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
    <div class="container mt-5">
        <a href="{{ route('checkout') }}" class="btn btn-success">Checkout</a>
    </div>
    
     <!-- bootstrap js and popper js -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
</body>
</html>
