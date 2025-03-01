@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Deleted Bookings</h2>
    </div>

    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Room Name</th>
                    <th scope="col">Room No</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Check in</th>
                    <th scope="col">Check out</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Booked On</th>
                    <th scope="col">Deleted At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($deletedOrders as $deletedOrder)
                    <tr>
                        <td>{{ $deletedOrder->order_id }}</td>
                        <td>{{ $deletedOrder->room_name }}</td>
                        <td>{{ $deletedOrder->room_no }}</td>
                        <td>{{ $deletedOrder->customer_name }}</td>
                        <td>{{ $deletedOrder->check_in }}</td>
                        <td>{{ $deletedOrder->check_out }}</td>
                        <td>${{ $deletedOrder->total_price }}</td>
                        <td>{{ $deletedOrder->booked_on }}</td>
                        <td>{{ $deletedOrder->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-primary fw-bold">No deleted orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
