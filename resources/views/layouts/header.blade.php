<div class="container-fluid bg-dark px-0">
    <div class="row gx-0 bg-white d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start">
            <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                <i class="fa fa-envelope text-primary me-2"></i>
                <p class="mb-0">info@example.com</p>
            </div>
            <div class="h-100 d-inline-flex align-items-center py-2">
                <i class="fa fa-phone-alt text-primary me-2"></i>
                <p class="mb-0">+1514 345 6789</p>
            </div>
        </div>
        <div class="col-lg-5 px-5 text-end">
            <div class="d-inline-flex align-items-center py-2">
                <a class="me-3" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="me-3" href=""><i class="fab fa-twitter"></i></a>
                <a class="me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="me-3" href=""><i class="fab fa-instagram"></i></a>
                <a class="" href=""><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="row gx-0">
        <div class="col-lg-3 bg-dark d-none d-lg-block">
            <a href="{{ route('home') }}"
                class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                <img src="img\logo4.png" alt="HOTELIA" class="logo" style="height: 80px; margin-right: 10px;">
                <div class="d-block"style="height: 5px; margin-bottom: 52px; margin-right: 100px; align-items-center justify-content-center">
                    <h1 class="m-0 title">EMPIRE</h1>
                <h2 class="m-0 subtitle">ROOMS</h2>
                </div>
        </a>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                <a href="{{ route('home') }}" class="navbar-brand d-flex d-lg-none">
                    <img src="img\logo4.png" alt="HOTELIA" class="logo" style="height: 80px; margin-right: 10px;">
                    <div class="d-block "style="height: 5px; margin-top: 10px; margin-right: 100px; align-items-center justify-content-center">
                        <h1 class="m-0 title">EMPIRE</h1>
                    <h2 class="m-0 subtitle">ROOMS</h2>
                    </div>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                           href="{{ route('home') }}">Home</a>
                        <a class="nav-item nav-link {{ request()->routeIs('rooms.index') ? 'active' : '' }}"
                           href="{{ route('rooms.index') }}">Rooms</a>
                        @guest()
                            <a class="nav-item nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                               href="{{ route('login') }}">Login</a>
                            <a class="nav-item nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                               href="{{ route('register') }}">Register</a>
                        @else
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link d-flex align-items-center" data-bs-toggle="dropdown">
                                    @if(Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                    alt="Profile Picture"
                                    class="rounded-circle"
                                    style="width: 30px; height: 30px; object-fit: cover;">
                                    @elseif(Auth::user()->is_admin)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                    alt="Profile Picture"
                                    class="rounded-circle"
                                    style="width: 30px; height: 30px; object-fit: cover;"
                                    href="{{ route('admin.index') }}"
                                    >
                                    @else
                                        <i class="fa-solid fa-user"></i>
                                    @endif
                                </a>
                                <div class="dropdown-menu rounded-0 m-0 u-icon">
                                    @if(Auth::user()->is_admin)
                                    <a href="{{ route('admin.index') }}" class="dropdown-item">{{ Auth::user()->name }}</a>
                                    <a href="{{ route('admin.orders.index') }}" class="dropdown-item">Orders</a>
                                    <form method="post" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-link dropdown-item">Logout</button>
                                    </form>
                                    @else
                                    <a href="{{ route('user.index') }}" class="dropdown-item">{{ Auth::user()->name }}</a>
                                    <a href="{{ route('orders.index') }}" class="dropdown-item">My Bookings</a>
                                    <a href="{{ route('profile') }}" class="dropdown-item">My Profile</a>
                                    <form method="post" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-link dropdown-item">Logout</button>
                                    </form>
                                    @endif
                                </div>
                            </div>

                        @endguest
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
