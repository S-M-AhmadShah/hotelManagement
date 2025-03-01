<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Response;
use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index(): View
    {
        // Total number of rooms
        $totalRooms = Room::sum('total_room');

        // Total reservations (future check-ins)
        $reservedRoom = Order::whereDate('check_in', '>=', now())->count();

        //available rooms
        $availableRooms = Room::where('status', true)
    ->sum('total_room') - Order::whereDate('check_in', '>=', now())->count();

        $monthlyRevenue = Order::join('rooms', 'orders.room_id', '=', 'rooms.id')
        ->selectRaw('MONTH(orders.check_in) as month, SUM(rooms.price * DATEDIFF(orders.check_out, orders.check_in)) as total_revenue')
        ->groupBy('month')
        ->pluck('total_revenue', 'month')
        ->toArray();

        // Fill in months with zero revenue if missing
        $formattedMonthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedMonthlyRevenue[$i] = $monthlyRevenue[$i] ?? 0; // Default to 0 if no revenue
        }
        // Return data to the dashboard view
        return view('admin.index', [
            'totalRooms' => $totalRooms,
            'reservedRoom' => $reservedRoom,
            'availableRooms' => $availableRooms,
            'revenue' =>  array_sum($formattedMonthlyRevenue), // Total revenue
            'monthlyRevenue' => $formattedMonthlyRevenue,
        ]);
    }


    public function customers(): View
    {
        $customers = User::all();

        return view('admin.customers', compact('customers'));
    }

    public function downloadBookingCSV()
{
    try {
        // Fetch the required data with joins
        $bookings = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id') // Join with users table
            ->join('rooms', 'orders.room_id', '=', 'rooms.id') // Join with rooms table
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id') // Join with room_types table
            ->select(
                'orders.id as order_id',
                'orders.room_no',
                'users.name as customer_name',
                'users.phone as phone_no',
                'users.email',
                'orders.check_in',
                'orders.check_out',
                'rooms.price',
                'room_types.name as room_type_name' // Fetch room type name
            )
            ->get();

        Log::info('Bookings fetched successfully.', ['bookings' => $bookings]);

        // Prepare CSV data
        $csvData = "Order ID,Room No,Customer Name,Phone No,Email,Check In,Check Out,Room Type,Total Price\n";

        foreach ($bookings as $booking) {
            // Calculate stay days
            $checkIn = new \DateTime($booking->check_in);
            $checkOut = new \DateTime($booking->check_out);
            $stayDays = $checkOut->diff($checkIn)->days;

            // Calculate total price
            $totalPrice = ($stayDays * $booking->price) + 25 + 15;

            $csvData .= "{$booking->order_id},{$booking->room_no},{$booking->customer_name},{$booking->phone_no},{$booking->email},{$booking->check_in},{$booking->check_out},{$booking->room_type_name},{$totalPrice}\n";
        }

        $filename = "booking_data_" . date('YmdHis') . ".csv";

        // Return CSV file as a response
        return Response::make($csvData, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}"
        ]);
    } catch (\Exception $e) {
        Log::error('Error generating CSV:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to generate CSV'], 500);
    }
}

}
