<?php

namespace App\Http\Controllers\Admin;
use App\Models\DeletedOrder;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View; // Import the correct View namespace

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $orders = Order::all();

        // Return data to the dashboard view
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $rooms = Room::all(); // Fetch all rooms
        $users = User::all(); // Fetch all users

        return view('admin.orders.edit', compact('order', 'rooms', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Validate the request data
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'check_in' => 'required|date|before:check_out',
            'check_out' => 'required|date|after:check_in',
        ]);

        // Fetch the room price from the database
        $room = Room::findOrFail($validated['room_id']);
        $roomPrice = $room->price;

        // Calculate the total price (number of days * room price)
        $checkInDate = new \DateTime($validated['check_in']);
        $checkOutDate = new \DateTime($validated['check_out']);
        $days = $checkOutDate->diff($checkInDate)->days;
        $totalPrice = $days * $roomPrice;

        // Update the order
        $order->update([
            'room_id' => $validated['room_id'],
            'user_id' => $validated['user_id'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'total_price' => $totalPrice,
        ]);

        // Redirect with a success message
        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            // Store deleted order details in the DeletedOrders table
            DeletedOrder::create([
                'order_id' => $order->id,
                'room_name' => $order->room->roomtype->name,
                'room_no' => $order->room_no,
                'customer_name' => $order->user->name,
                'check_in' => $order->check_in,
                'check_out' => $order->check_out,
                'total_price' => $order->room->price * $order->stayDays + 25 + 15,
                'booked_on' => $order->created_at,
            ]);

            // Delete the order
            $order->delete();

            return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully and stored in history.');
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Failed to delete the order: ' . $e->getMessage());
        }
    }

 

}
