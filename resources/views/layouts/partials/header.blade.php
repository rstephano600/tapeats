<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top shadow-sm">
    <div class="container-fluid">
        <!-- Toggle Button for Sidebar -->
        <button class="btn btn-darkblue d-lg-none" id="sidebarToggle" type="button">
            <i class="bi bi-list text-white"></i>
        </button>
        
        <!-- Toggle Button for desktop (hidden by default, but can be used) -->
        <button class="btn btn-darkblue d-none d-lg-inline-block" id="sidebarToggle">
            <i class="bi bi-list text-white"></i>
        </button>

        <!-- Current User Role Display -->
        <span class="navbar-text ms-3 me-auto d-none d-sm-block">
            Current Role: <span class="badge bg-darkblue">
                {{-- Dynamically display the user's role from the auth object --}}
                @if(Auth::check())
                    {{ ucwords(Auth::user()->role) }} 
                @else
                    Guest
                @endif
            </span>
        </span>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(Auth::check())
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        @else
                            <i class="bi bi-person-circle me-1"></i> My Account
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Profile Settings</a>
                        <a class="dropdown-item" href="#">Notifications</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>