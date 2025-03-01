@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Order</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <select class="form-control" id="room_id" name="room_id" required>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" data-price="{{ $room->price }}" {{ $order->room_id == $room->id ? 'selected' : '' }}>
                            {{ $room->roomtype->name }} (Room ID: {{ $room->id }}, Price: ${{ $room->price }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">Customer</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="check_in" class="form-label">Check-in Date</label>
                <input type="date" class="form-control" id="check_in" name="check_in" value="{{ $order->check_in }}" required>
            </div>

            <div class="mb-3">
                <label for="check_out" class="form-label">Check-out Date</label>
                <input type="date" class="form-control" id="check_out" name="check_out" value="{{ $order->check_out }}" required>
            </div>

            <div class="mb-3">
                <label for="total_price" class="form-label">Total Price</label>
                <input type="number" class="form-control" id="total_price" name="total_price" readonly>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary" >Update Order</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomSelect = document.getElementById('room_id');
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const totalPriceInput = document.getElementById('total_price');

        function calculateTotalPrice() {
            const selectedRoom = roomSelect.options[roomSelect.selectedIndex];
            const roomPrice = parseFloat(selectedRoom.getAttribute('data-price'));
            const checkInDate = new Date(checkInInput.value);
            const checkOutDate = new Date(checkOutInput.value);

            if (!isNaN(roomPrice) && checkInDate && checkOutDate && checkOutDate > checkInDate) {
                const days = (checkOutDate - checkInDate) / (1000 * 60 * 60 * 24);
                totalPriceInput.value = roomPrice * days;
            } else {
                totalPriceInput.value = 0;
            }
        }

        roomSelect.addEventListener('change', calculateTotalPrice);
        checkInInput.addEventListener('change', calculateTotalPrice);
        checkOutInput.addEventListener('change', calculateTotalPrice);
    });
</script>
