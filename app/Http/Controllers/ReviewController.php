<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create()
    {
        $user = auth()->user(); // Get the logged-in user
        $reviews = $user ? $user->reviews : collect(); // Fallback to an empty collection if no user
        return view('user.reviews.create', compact('reviews'));
    }

    // Fetch approved reviews (for public view) and pending reviews (for admin)
    public function index()
    {
        $reviews = Review::where('is_approved', 1)->get(); // Approved reviews
        // If the logged-in user is an admin, fetch pending reviews
        $pendingReviews = auth()->check() && auth()->user()->is_admin
            ? Review::where('is_approved', 0)->get()
            : collect();
        return view('sections.reviews', compact('reviews', 'pendingReviews'));
    }

    // Store a new review
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5', // Ensure rating is between 1 and 5
            'feedback' => 'required|string|max:1000',  // Limit feedback to 1000 characters
        ]);

        // Create the review and associate it with the logged-in user
        Review::create([
            'user_id' => auth()->id(),        // ID of the logged-in user
            'feedback' => $validated['feedback'],
            'rating' => $validated['rating'],
            'is_approved' => 0,               // Mark the review as pending approval
        ]);

        // Redirect back with a success message
        return redirect()->route('user.reviews.create')->with('success', 'Your review has been submitted and is awaiting approval.');
    }

    // Approve a pending review (admin only)
    public function approve($id)
    {
        $reviews = Review::findOrFail($id);

        if (!auth()->user()->is_admin) {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }

        $reviews->is_approved = 1; // Mark as approved
        $reviews->save();

        return redirect()->back()->with('success', 'Review approved successfully!');
    }

    public function reviews()
    {
        $allReviews = Review::all();
        return view('admin.reviews', compact('allReviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
