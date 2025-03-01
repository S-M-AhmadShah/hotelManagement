@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Upcoming Booking</h2>
    </div>

    <div class="card-body">
        <table id="bookingsTable" class="table table-striped">
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
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->room->roomtype->name }}</td>
                        <td>{{ $order->room_no}}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->check_in }}</td>
                        <td>{{ $order->check_out }}</td>
                        <td>${{ $order->room->price * $order->stayDays + 25 +15}}</td>
                        <td>{{ $order->created_at }}</td>

                        <td>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning fa-solid fa-pen-to-square"></a>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger  fa-solid fa-trash-can" onclick="return confirm('Are you sure you want to delete this booking?')"></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-primary fw-bold">You don't have any orders.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <button id="downloadCsvButton">Download CSV</button>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#bookingsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
    });
</script>
@endpush
