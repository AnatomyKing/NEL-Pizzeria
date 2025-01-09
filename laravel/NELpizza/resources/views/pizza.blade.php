{{-- resources/views/pizza.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Best Selling Pizzas</h2>

        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="color: red;">
                {{ session('error') }}
            </div>
        @endif

        <div class="pizza-list" style="display: flex; gap: 20px; flex-wrap: wrap;">
            @foreach($pizzas as $pizza)
                <div style="border: 1px solid #ccc; padding: 15px; width: 200px;">
                    <h3>{{ $pizza['name'] }}</h3>
                    <p>{{ $pizza['description'] }}</p>
                    <p><strong>Price:</strong> ${{ number_format($pizza['price'], 2) }}</p>

                    <form action="{{ route('pizza.addToCart', $pizza['id']) }}" method="POST">
                        @csrf
                        <button type="submit">Add to Basket</button>
                    </form>
                </div>
            @endforeach
        </div>

        <hr>

        <h2>Your Basket</h2>
        @php
            $cart = session()->get('cart', []);
        @endphp

        @if(count($cart) > 0)
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Pizza</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach($cart as $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>
                                {{-- Update quantity form --}}
                                <form action="{{ route('pizza.updateCart', $item['id']) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width:50px;">
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                            <td>${{ number_format($subtotal, 2) }}</td>
                            <td>
                                {{-- Remove form --}}
                                <form action="{{ route('pizza.removeFromCart', $item['id']) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right"><strong>Total:</strong></td>
                        <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        @else
            <p>Your basket is empty.</p>
        @endif
    </div>
@endsection
