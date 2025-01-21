@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Orders Dashboard</h1>

    @if ($bestellings->isEmpty())
        <p>No orders have been placed yet.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Order Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bestellings as $bestelling)
                    <tr>
                        <td>{{ $bestelling->id }}</td>
                        <td>{{ $bestelling->customer_name ?? 'N/A' }}</td> <!-- Replace column -->
                        <td>{{ $bestelling->created_at }}</td>
                        <td>
                            <ul>
                                @foreach ($bestelling->bestelregels as $regel)
                                    <li>
                                        Pizza: {{ $regel->pizza_name ?? 'N/A' }} - Quantity: {{ $regel->quantity ?? 0 }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
