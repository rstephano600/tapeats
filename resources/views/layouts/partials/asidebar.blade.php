
<div class="border-end bg-darkblue" id="sidebar-wrapper">
    <div class="sidebar-heading text-white fw-bold border-bottom border-secondary">
        TapEats
    </div>
    
    <div class="list-group list-group-flush">
        
        {{-- Default Links for all Logged-in Users --}}
        <a href="{{ url('/dashboard') }}" class="list-group-item list-group-item-action">
            <i class="bi bi-house-door me-2"></i> Dashboard Home
        </a>
        <a href="{{ route('customer.orders') }}" class="list-group-item list-group-item-action">
            <i class="bi bi-basket me-2"></i> My Orders
        </a>

        {{-- Role-Based Navigation Logic --}}
        @if(Auth::check())
            @php $role = Auth::user()->role; @endphp

            @switch($role)
                {{-- 1. Super Admin / Admin Links --}}
                @case('super_admin')
                @case('admin')
                    <div class="list-group-item list-group-item-action bg-secondary text-white fw-bold mt-2">ADMIN TOOLS</div>
                    <a href="{{ url('/admin/users') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-people me-2"></i> User Management
                    </a>
                    <a href="{{ route('admin.suppliers.pending') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-shop me-2"></i> Supplier Approval
                    </a>
                    @if($role == 'super_admin')
                    <a href="{{ url('/superadmin/settings') }}" class="list-group-item list-group-item-action text-danger">
                        <i class="bi bi-gear-fill me-2"></i> System Settings
                    </a>
                    @endif
                    @break

                {{-- 2. Supplier Links --}}
                @case('supplier')
                    <div class="list-group-item list-group-item-action bg-secondary text-white fw-bold mt-2">SUPPLIER PORTAL</div>
                    <a href="{{ route('supplier.foods.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-card-list me-2"></i> Manage Menu & Costs
                    </a>
                    <a href="{{ route('supplier.orders') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-clipboard-check me-2"></i> New Orders
                    </a>
                    <a href="{{ url('/supplier/reports') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-graph-up me-2"></i> Sales Reports
                    </a>
                    <a href="{{ route('business.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-shop me-2"></i> Manage Business
                    </a>
                    @break

                {{-- 3. Delivery Links --}}
                @case('delivery')
                    <div class="list-group-item list-group-item-action bg-secondary text-white fw-bold mt-2">DELIVERY PORTAL</div>
                    <a href="{{ url('/delivery/map') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-geo-alt me-2"></i> Route Map
                    </a>
                    <a href="{{ url('/delivery/queue') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-truck me-2"></i> Delivery Queue
                    </a>
                    @break

                {{-- 4. Customer / Normal User Links --}}
                @case('customer')
                @case('normal_user')
                    <div class="list-group-item list-group-item-action bg-secondary text-white fw-bold mt-2">ORDERING</div>
                    <a href="{{ route('menu.foods.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-cart me-2"></i> Food Menu
                    </a>
                    <a href="{{ url('/search') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-search me-2"></i> Search Suppliers
                    </a>
                    <a href="{{ url('/cart') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-cart me-2"></i> Shopping Cart
                    </a>
                    @break
                    
            @endswitch
        @endif

        {{-- Logout Link (Appears at the bottom of the sidebar) --}}
        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger mt-4"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
</div>