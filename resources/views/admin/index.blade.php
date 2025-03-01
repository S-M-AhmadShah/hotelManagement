@extends('layouts.app')

@section('content')
<div class="d-flex">

    <!-- Main Content -->
    <div class="container-fluid ms-auto px-4" style="margin-left: 250px;">
        <!-- Header -->

        <header class="d-flex justify-content-between align-items-center py-3 border-bottom">
            <h2 class="mb-0">Admin Dashboard</h2>
            <div class="d-flex align-items-center">
                <input type="text" class="form-control me-3" placeholder="Search...">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2"></i> Admin
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <button type="menu" class="btn btn-link dropdown-item">logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Summary Cards -->
        <div class="row my-4">
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-header">
                        <i class="bi bi-door-closed me-2"></i>Total Rooms
                    </div>
                    <div class="card-body text-center">
                        <h3>{{ $totalRooms }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-header">
                        <i class="bi bi-calendar-check me-2"></i>Total Reservations
                    </div>
                    <div class="card-body text-center">
                        <h3>{{ $reservedRoom }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-info shadow-sm">
                    <div class="card-header">
                        <i class="bi bi-door-open me-2"></i>Available Rooms
                    </div>
                    <div class="card-body text-center">
                        <h3>{{ $availableRooms }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-dark shadow-sm">
                    <div class="card-header">
                        <i class="bi bi-cash-coin me-2"></i>Total Revenue
                    </div>
                    <div class="card-body text-center">
                        <h3 class="text-white">${{ $revenue }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <i class="bi bi-bar-chart me-2"></i>Revenue Trends
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <i class="bi bi-pie-chart me-2"></i>Room Status Distribution
                    </div>
                    <div class="card-body">
                        <canvas id="roomStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center py-4 mt-5 border-top">
            <p>&copy; {{ date('Y') }} Hotel Management System. Built with ❤️ by Ahmad.</p>
        </footer>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
       // Pass PHP data to JavaScript
       const monthlyRevenue = @json(array_values($monthlyRevenue)); // Convert to indexed array
    const revenueLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    // Create the revenue chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue ($)',
                data: monthlyRevenue, // Use the dynamic data
                borderColor: '#4caf50',
                backgroundColor: 'rgba(76, 175, 80, 0.2)',
                fill: true,
            }]
        }
    });
    const roomStatusCtx = document.getElementById('roomStatusChart').getContext('2d');
    const roomStatusChart = new Chart(roomStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Reserved'],
            datasets: [{
                data: [{{ $availableRooms }}, {{ $reservedRoom }}],
                backgroundColor: ['#17a2b8', '#28a745', '#ffc107'],
                hoverOffset: 4
            }]
        }
    });
</script>
@endsection
