<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container-fluid container-xxl">
        <a class="navbar-brand fw-bold text-custom-orange" href="{{ url('/') }}">{{ config('app.name', 'FoodApp') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('menu') }}">Menu</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.orders') }}">My Orders</a>
                </li>
                @endauth
            </ul>
            <div class="d-flex">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-custom-orange me-2">Login</a>
                @else
                    <button class="btn btn-outline-secondary me-2" onclick="document.getElementById('logout-form').submit();">Logout</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
                
                {{-- Cart Toggle Button --}}
                <button class="btn btn-custom-orange position-relative" type="button" onclick="toggleCart()">
                    <i class="fas fa-shopping-cart me-1"></i> Cart
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartItemCount">
                        0
                    </span>
                </button>
            </div>
        </div>
    </div>
</nav>