<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Testimonial Page</title>
</head>
<body>
<div class="container-xxl testimonial my-5 py-5 bg-dark wow zoomIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-title text-center text-primary text-uppercase">Customer Reviews</h6>
            <h1 class="mb-5 text-white">What Our <span class="text-primary text-uppercase">Customers Say</span></h1>
        </div>
        <div class="owl-carousel testimonial-carousel py-5">
            @foreach ($reviews->take(3) as $review) <!-- Show only 3 reviews -->
            @php
                $user = \Illuminate\Support\Facades\DB::table('users')->where('id', $review->user_id)->first();
            @endphp
            <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        @if ($user && $user->profile_picture)
                            <img class="img-fluid flex-shrink-0 rounded" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture"  style="width: 45px; height: 45px;">
                        @else
                            <img class="img-fluid flex-shrink-0 rounded" src="{{ asset('storage/default-profile.png') }}" alt="Default Profile Picture"  style="width: 45px; height: 45px;">
                        @endif
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">{{ $user->name ?? 'Anonymous' }}</h6>
                            <p>
                                <strong>Rating:</strong>
                                <span class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fas fa-star text-warning"></i> <!-- Filled Star -->
                                        @else
                                            <i class="far fa-star text-warning"></i> <!-- Empty Star -->
                                        @endif
                                    @endfor
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <p>
                    <span class="feedback-short">
                        {{ Str::limit($review->feedback, 100) }} <!-- Display shortened feedback -->
                    </span>
                    <span class="feedback-full d-none">
                        {{ $review->feedback }} <!-- Display full feedback -->
                    </span>
                    @if(strlen($review->feedback) > 100)
                        <a href="#" class="read-more-link">Read More</a>
                    @endif
                </p>
                <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".read-more-link").forEach(link => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const feedbackShort = link.previousElementSibling.previousElementSibling;
                const feedbackFull = link.previousElementSibling;
                if (feedbackFull.classList.contains("d-none")) {
                    feedbackShort.classList.add("d-none");
                    feedbackFull.classList.remove("d-none");
                    link.textContent = "Read Less";
                } else {
                    feedbackShort.classList.remove("d-none");
                    feedbackFull.classList.add("d-none");
                    link.textContent = "Read More";
                }
            });
        });
    });
</script>
</body>
</html>
