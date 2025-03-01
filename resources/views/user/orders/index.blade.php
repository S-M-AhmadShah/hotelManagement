@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2>My Booking</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Room No</th>
                    <th scope="col">Room Name</th>
                    <th scope="col">Check in</th>
                    <th scope="col">Check out</th>
                    <th scope="col">Service Charges</th>
                    <th scope="col">Total price</th>
                    <th scope="col">Booked on</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->room_no }}</td>
                        <td>{{ $order->room->roomtype->name }}</td>
                        <td>{{ $order->check_in }}</td>
                        <td>{{ $order->check_out }}</td>
                        <td>25$ + 15$(Laundry)</td>
                        <td>${{ $order->room->price * $order->stayDays + 25 + 15}}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</button>
                            </form>
                        </td>

                        <td>
                            <a href="{{ route('orders.report', $order->id) }}" class="btn btn-primary">Generate Report</a>
                        </td>
                    </tr>
                @empty
                    <p class="text-primary fw-bold">You don't have any orders.</p>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Newsletter -->
    @include('sections.newsletter')
@endsection
