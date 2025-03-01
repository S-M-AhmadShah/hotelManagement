<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller {

    public function index(): View {

        $rooms = Room::with('roomtype')->where('status', 1)->get();
        $reviews = Review::where('is_approved', 1)->get();
        return view('pages.home', compact('rooms', 'reviews'));
    }

    public function list_rooms() {
        $rooms = Room::with('roomtype')->where('status', 1)->get();
        $reviews = Review::where('is_approved', 1)->get(); // Approved reviews
        return view('pages.list-rooms', compact('rooms', 'reviews'));
    }

    public function search(Request $request) {

        $validatedData = $request->validate([
            'check_in' => ['required', 'date', 'after:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'no_peron' => ['required']
        ]);

        $rooms = Room::with('roomtype')
    ->where('status', 1)
    ->whereHas('orders', function (Builder $query) use ($validatedData) {
        $query->whereBetween('check_in', [$validatedData['check_in'], $validatedData['check_out']])
            ->orWhereBetween('check_out', [$validatedData['check_in'], $validatedData['check_out']]);
    }, '<', DB::raw('rooms.total_room'))
    ->withCount([
        'orders as booked_rooms_count' => function (Builder $query) use ($validatedData) {
            $query->whereBetween('check_in', [$validatedData['check_in'], $validatedData['check_out']])
                ->orWhereBetween('check_out', [$validatedData['check_in'], $validatedData['check_out']]);
        }
    ])
    ->get()
    ->each(function ($room) {
        $room->not_booked_rooms_count = $room->total_room - $room->booked_rooms_count;
    });
    // dd($rooms);

        $searched = true;
        $fields = $validatedData;
        $reviews = Review::where('is_approved', 1)->get(); // Approved reviews
        return view('pages.list-rooms', compact('rooms', 'searched', 'fields', 'reviews'));
    }

    public function showProfile() {
        return view('pages.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request) {
        $user = Auth::user();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->save();

        return redirect()->route('profile');
    }
}
