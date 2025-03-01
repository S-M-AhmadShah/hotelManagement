<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth::user();
        $orders = $user->orders()->with('room.roomtype')->orderBy('check_in', 'DESC')->get();
        return view('user.orders.index', ['orders' => $orders]);
    }

    public function store(Request $request) {
        $user = Auth::user();
        $booked_rooms_count = $request->input('booked_rooms_count');
        $room_no = $booked_rooms_count + 1;
        // Step 1: Save the order without the room_no first
        $order = new Order([
            'check_in' => $request->input('check_in'),
            'check_out' => $request->input('check_out'),
            'room_id' => $request->input('room_id'),
            'room_no' => $room_no,

        ]);
        $user->orders()->save($order);
        $order->save();

        // Step 3: Redirect based on the user's role
        if ($user->is_admin) {
            return redirect()->route('admin.orders.index')
                ->with('message', 'Your order has been created successfully!');
        } else {
            return redirect()->route('orders.index')
                ->with('message', 'Your order has been created successfully!');
        }
    }

    public function generatePDF(Order $order) {
        $order->load('room.roomtype');
        $pdf = \PDF::loadView('user.orders.report', compact('order'));
        return $pdf->download('order-report.pdf');
    }
    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);

        // Add the order record to the `deleted_orders` table
        DB::table('deleted_orders')->insert([
                    'order_id' => $order->id,
                    'room_name' => $order->room->roomtype->name,
                    'room_no' => $order->room_no,
                    'customer_name' => $order->user->name,
                    'check_in' => $order->check_in,
                    'check_out' => $order->check_out,
                    'total_price' => $order->room->price * $order->stayDays + 25 + 15,
                    'booked_on' => $order->booked_on,
        ]);

        // Delete the order record from `orders` table
        $order->delete();

        return redirect()->back()->with('success', 'Order canceled successfully.');
    }
}
