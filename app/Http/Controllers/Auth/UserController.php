<?php

namespace App\Http\Controllers\Auth;

use App\Models\Order;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // Import Auth
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View
    {
        $reservedRoom = Order::where('user_id', Auth::id()) // Filter by authenticated user
                             ->whereDate('check_in', '>=', Carbon::now())
                             ->count();

        return view('user.index', compact('reservedRoom'));
    }
}
