@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Success message for pending approval -->
    @if(session('success'))
        <div class="alert alert-success text-center mt-3 rounded-pill shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Review Submission Form -->
    <div class="card shadow-lg mb-5 rounded-3">
        <div class="card-header bg-gradient bg-primary text-white text-center rounded-top">
            <h4 class="mb-0">Submit Your Feedback</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('user.reviews.store') }}" method="POST">
                @csrf
                <!-- Dynamic Star Rating -->
                <div class="mb-4">
                    <label for="rating" class="form-label fw-bold">Your Rating</label>
                    <div id="star-rating" class="d-flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star-o rating-star fs-4 text-warning pointer" data-value="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="" required>
                    @error('rating')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Feedback Text -->
                <div class="mb-4">
                    <label for="feedback" class="form-label fw-bold">Your Feedback</label>
                    <textarea name="feedback" id="feedback" class="form-control shadow-sm @error('feedback') is-invalid @enderror" rows="5" placeholder="Write your feedback here..." required></textarea>
                    @error('feedback')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- List of User's Reviews -->
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-gradient bg-secondary text-white text-center rounded-top">
            <h4 class="mb-0">Your Reviews</h4>
        </div>
        <div class="card-body">
            @if($reviews->isEmpty())
                <div class="text-center py-4">
                    <i class="fa fa-comments-o text-muted fs-1"></i>
                    <p class="text-muted mt-2">You have not submitted any reviews yet.</p>
                </div>
            @else
                <ul class="list-group">
                    @foreach($reviews as $review)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">
                                        Rating:
                                        <span class="text-warning">
                                            @for($i = 1; $i <= $review->rating; $i++)
                                                <i class="fa fa-star"></i>
                                            @endfor
                                        </span>
                                    </h6>
                                    <p class="mb-1">{{ $review->feedback }}</p>
                                    <span class="badge {{ $review->is_approved ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $review->is_approved ? 'Approved' : 'Pending Approval' }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<!-- Include FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .pointer {
        cursor: pointer;
    }

    .rating-star:hover {
        color: #ffc107 !important;
        transform: scale(1.2);
        transition: transform 0.2s, color 0.2s;
    }

    button:hover {
        background-color: #0056b3 !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('rating-input');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-value');
                ratingInput.value = rating;

                // Highlight stars up to the selected one
                stars.forEach(s => s.classList.remove('fa-star', 'text-warning'));
                stars.forEach(s => s.classList.add('fa-star-o'));
                for (let i = 0; i < rating; i++) {
                    stars[i].classList.remove('fa-star-o');
                    stars[i].classList.add('fa-star', 'text-warning');
                }
            });
        });
    });
</script>
@endsection
