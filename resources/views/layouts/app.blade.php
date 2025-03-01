<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet"/>

    <!-- Customized Bootstrap Stylesheet-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Hotel Management System</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <style>
        .title {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 5;
            color: #d4af36; /* Gold color */
        }
        .subtitle {
            font-family: 'Roboto', sans-serif;
            font-weight: 1;
            font-size: 20px;
            color: #ffffff; /* White color */
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <!-- Admin Panel -->
    @if(isset($adminView))
        <div class="container-fluid">
            <div class="row flex-nowrap">
                @include('admin.sidebar')
                <div class="col py-3">
                    @yield('content')
                </div>
            </div>
        </div>
    @elseif(isset($userView))
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('user.sidebar')
            <div class="col py-3">
                @yield('content')
            </div>
        </div>
    </div>
    @else
        <!-- Default App View -->
        <div class="container-xxl bg-white p-0">
            <!-- Spinner loading  -->
            @include('components.spinner')
            <!-- Header -->
            @yield('header')
            <!-- Content -->
            @yield('content')
            <!-- Footer -->
            @yield('footer')
        </div>
    @endif

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <link rel="stylesheet" href="path/to/owl.carousel.min.css">
    <link rel="stylesheet" href="path/to/owl.theme.default.min.css">
    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/owl.carousel.min.js"></script>

<!-- jQuery-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Bootstrap JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('downloadCsvButton').addEventListener('click', function () {
    fetch('/download-booking-csv', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = "booking_data.csv"; // Fallback filename
        document.body.appendChild(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('Error downloading CSV:', error);
    });
});
</script>
@stack('scripts')

</body>
</html>
