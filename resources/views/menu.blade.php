<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TapEats - Order Your Favorite Food</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        /* Custom Orange and Red Color for primary elements */
        :root {
            --bs-primary: #ff6e40; /* A middle ground orange/red */
            --bs-secondary: #f8f9fa; /* Light gray for background */
            --bs-link-color: #ff6e40;
            --bs-link-hover-color: #ff5722;
        }

        .bg-gradient-custom {
            background: linear-gradient(to right, #ff9800, #ff5722);
        }
        
        .btn-custom-orange {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            color: white;
        }
        .btn-custom-orange:hover {
            background-color: #ff5722;
            border-color: #ff5722;
            color: white;
        }

        /* Equivalent of Tailwind fadeIn/pulse (can be kept or removed) */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.5s ease-out; }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .cart-badge { animation: pulse 0.3s ease-out; }

        /* Sidebar Styling (using fixed positioning and custom classes) */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 100%; /* Full width on small devices */
            max-width: 384px; /* w-96 equivalent (384px) */
            background-color: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            z-index: 1050; /* Higher than Bootstrap modals/navbars */
            display: flex;
            flex-direction: column;
        }

        /* For responsiveness: make sidebar full height on small screens */
        @media (min-width: 576px) {
            .cart-sidebar {
                width: 90%;
            }
        }
        @media (min-width: 768px) {
            .cart-sidebar {
                width: 384px;
            }
        }

        .cart-sidebar.show {
            transform: translateX(0);
        }

        .cart-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }
    </style>
</head>
<body class="bg-light">
    <header class="shadow-sm sticky-top bg-white">
        <div class="container-fluid container-md">
            <div class="d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-custom text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-size: 1.25rem; font-weight: bold;">
                        TE
                    </div>
                    <h1 class="h4 fw-bold text-dark mb-0">TapEats</h1>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="me-3 d-none d-sm-block">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" id="search-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search text-secondary" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.135.2.22.428.22.682a6.5 6.5 0 0 0 1.242 3.124l4.481 4.481a1 1 0 0 0 1.414-1.414l-4.481-4.481a6.5 6.5 0 0 0-.682-.22zM6.5 13A6.5 6.5 0 1 1 6.5 0a6.5 6.5 0 0 1 0 13z"/>
                                </svg>
                            </span>
                            <input type="text" 
                                   placeholder="Search food..." 
                                   class="form-control border-start-0 ps-0 rounded-start-0" 
                                   id="searchInput"
                                   aria-label="Search" aria-describedby="search-addon"
                                   style="width: 200px;">
                        </div>
                    </div>
                    
                    <button class="btn btn-custom-orange rounded-pill px-3 py-2" onclick="toggleCart()">
                        <span class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-cart me-2" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L5.454 8l.216 1.082a.5.5 0 0 1-.791.134L3.483 8.5A.5.5 0 0 1 3 8V5.5a.5.5 0 0 1 1 0V7.5l1.5 1.5L6.96 8.5A.5.5 0 0 1 7.454 8l.41-2.05L8 4.5a.5.5 0 0 1 1 0v1.45l.41 2.05L12.062 10l-.47-2.35L10.5 5.5a.5.5 0 0 1 1 0V7.5l1.5 1.5L14.454 8l.41-2.05L15 4.5a.5.5 0 0 1 1 0V5.5a.5.5 0 0 1-.485.379L13 8l-.454 2.27A1.5 1.5 0 0 1 11.062 11l-3.5 3.5a1.5 1.5 0 0 1-2.122 0L2.438 11A1.5 1.5 0 0 1 1.5 9.727L0 1.5zm11.5 1.5a.5.5 0 0 0-1 0v.5a.5.5 0 0 0 1 0v-.5zm-4 0a.5.5 0 0 0-1 0v.5a.5.5 0 0 0 1 0v-.5zm-4 0a.5.5 0 0 0-1 0v.5a.5.5 0 0 0 1 0v-.5z"/>
                            </svg>
                            <span class="d-none d-sm-inline me-2">Cart</span>
                            <span class="cart-badge bg-white text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 0.875rem;" id="cartCount">0</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="bg-white border-bottom">
        <div class="container-fluid container-md py-3">
            <div class="d-flex overflow-x-auto gap-2 pb-2">
                <button class="category-btn btn btn-custom-orange rounded-pill text-nowrap" data-category="all">All</button>
                @foreach($categories as $category)
                <button class="category-btn btn btn-light text-nowrap rounded-pill text-dark-emphasis" data-category="{{ $category }}">
                    {{ ucfirst($category) }}
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <main class="container-fluid container-md py-4">
<div class="mb-5">
    <h2 class="h5 fw-bold text-dark mb-4">Popular Suppliers</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4" id="suppliersGrid">
        @foreach($suppliers as $supplier)
        <div class="col">
            {{-- Use an anchor tag around the card for navigation --}}
            <a href="{{ route('menu.supplier', ['id' => $supplier->id]) }}" class="text-decoration-none text-dark">
                <div class="fade-in card shadow-sm h-100 border-0 rounded-3 overflow-hidden cursor-pointer">
                    @if($supplier->logo)
                    <img src="{{ asset('storage/' . $supplier->logo) }}" alt="{{ $supplier->business_name }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                    @else
                    <div class="w-100 bg-gradient-custom d-flex align-items-center justify-content-center" style="height: 180px;">
                        <span class="text-white h1 fw-bold">{{ substr($supplier->business_name, 0, 2) }}</span>
                    </div>
                    @endif
                    <div class="card-body p-3">
                        <h3 class="card-title h6 fw-bold mb-2">{{ $supplier->business_name }}</h3>
                        <div class="d-flex justify-content-between align-items-center small text-secondary">
                            <span>📍 {{ $supplier->region ?? 'Location' }}</span>
                            <span class="badge {{ $supplier->is_verified ? 'text-bg-success' : 'text-bg-light text-secondary border' }} rounded-pill">
                                {{ $supplier->is_verified ? '✓ Verified' : 'Pending' }}
                            </span>
                        </div>
                        @if($supplier->description)
                        <p class="card-text small text-muted mt-2 text-truncate">{{ $supplier->description }}</p>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

        <div>
            <h2 class="h5 fw-bold text-dark mb-4">Menu</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="menuGrid">
                @forelse($foods as $food)
                <div class="col food-item" 
                     data-category="{{ $food->category }}" 
                     data-supplier="{{ $food->supplier_id }}"
                     data-available="{{ $food->available ? 'true' : 'false' }}">
                    <div class="fade-in card shadow-sm h-100 border-0 rounded-3 overflow-hidden hover-shadow-lg transition">
                        @if($food->image)
                        <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->food_name }}" class="card-img-top" style="height: 192px; object-fit: cover;">
                        @else
                        <div class="w-100 bg-light-subtle d-flex align-items-center justify-content-center" style="height: 192px;">
                            <span class="text-secondary opacity-50 display-6">🍽️</span>
                        </div>
                        @endif
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h3 class="card-title h6 fw-bold mb-0">{{ $food->food_name }}</h3>
                                @if(!$food->available)
                                <span class="badge text-bg-danger rounded-pill flex-shrink-0 ms-2">Unavailable</span>
                                @endif
                            </div>
                            <p class="card-text small text-muted mb-1">
                                {{ $food->supplier->business_name ?? 'Unknown Supplier' }}
                            </p>

                            @if($food->description)
                            <p class="card-text small text-secondary mb-3 text-truncate">{{ $food->description }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 fw-bold text-primary mb-0">TSh {{ number_format($food->price, 0) }}</span>
                                @if($food->available)
                                <button onclick="addToCart({{ $food->id }}, '{{ $food->food_name }}', {{ $food->price }}, '{{ $food->image ? asset('storage/' . $food->image) : '' }}', {{ $food->supplier_id }}, {{ $food->business_id }})" 
                                        class="btn btn-sm btn-custom-orange rounded-3">
                                    Add +
                                </button>
                                @else
                                <button disabled class="btn btn-sm btn-secondary disabled rounded-3">
                                    Unavailable
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-secondary h5">No menu items available yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>

    <div id="cartSidebar" class="cart-sidebar overflow-auto">
        <div class="d-flex flex-column h-100">
            <div class="d-flex justify-content-between align-items-center p-4 border-bottom flex-shrink-0">
                <h3 class="h5 fw-bold mb-0" id="cartTitle">Your Cart</h3>
                <button type="button" class="btn-close" aria-label="Close" onclick="closeCheckout()"></button>
            </div>
            
            <div id="cartView" class="d-flex flex-column flex-grow-1">
                <div id="cartItems" class="flex-grow-1 overflow-auto p-4">
                    <p class="text-secondary text-center py-5">Your cart is empty</p>
                </div>
                
                <div class="border-top p-4 flex-shrink-0">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-semibold">Total:</span>
                        <span class="fw-bold h5 text-primary" id="cartTotal">TSh 0</span>
                    </div>
                    <button class="w-100 btn btn-custom-orange py-3 rounded-lg fw-semibold" onclick="proceedToCheckout()">
                        Proceed to Checkout
                    </button>
                </div>
            </div>

            <div id="checkoutView" class="d-flex flex-column flex-grow-1 d-none">
                <div class="flex-grow-1 overflow-auto p-4">
                    <form id="checkoutForm" class="vstack gap-3">
                        <div class="form-group">
                            <label for="fullName" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-lg" id="fullName" name="full_name" required placeholder="Enter your full name">
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control rounded-lg" id="phone" name="phone" required placeholder="+255 XXX XXX XXX">
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label fw-semibold">Delivery Address <span class="text-danger">*</span></label>
                            <textarea class="form-control rounded-lg" id="address" name="address" required rows="3" placeholder="Enter your delivery address"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="region" class="form-label fw-semibold">Region/City <span class="text-danger">*</span></label>
                            <select class="form-select rounded-lg" id="region" name="region" required>
                                <option value="">Select region</option>
                                <option value="Dodoma">Dodoma</option>
                                <option value="Dar es Salaam">Dar es Salaam</option>
                                <option value="Arusha">Arusha</option>
                                <option option="Mwanza">Mwanza</option>
                                <option value="Mbeya">Mbeya</option>
                                <option value="Morogoro">Morogoro</option>
                                <option value="Tanga">Tanga</option>
                                <option value="Zanzibar">Zanzibar</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                            <div class="vstack gap-2">
                                <div class="form-check border p-3 rounded-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cashOnDelivery" value="cash" checked>
                                    <label class="form-check-label" for="cashOnDelivery">
                                        💵 Cash on Delivery
                                    </label>
                                </div>
                                <div class="form-check border p-3 rounded-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="mobileMoney" value="mobile_money">
                                    <label class="form-check-label" for="mobileMoney">
                                        📱 Mobile Money (M-Pesa/Tigo Pesa)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-label fw-semibold">Special Instructions (Optional)</label>
                            <textarea class="form-control rounded-lg" id="notes" name="notes" rows="2" placeholder="Any special requests or delivery instructions?"></textarea>
                        </div>

                        <div class="bg-light p-3 rounded-3">
                            <h4 class="fw-semibold h6 mb-3">Order Summary</h4>
                            <div class="small text-secondary vstack gap-2">
                                <div class="d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span id="checkoutSubtotal">TSh 0</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Delivery Fee:</span>
                                    <span id="deliveryFee">TSh 0</span>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex justify-content-between fw-bold text-dark-emphasis">
                                    <span>Total:</span>
                                    <span class="text-primary h6 fw-bold mb-0" id="checkoutTotal">TSh 0</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="border-top p-4 d-grid gap-2 flex-shrink-0">
                    <button onclick="confirmOrder()" 
                            class="btn btn-custom-orange py-3 rounded-lg fw-semibold">
                        Place Order
                    </button>
                    <button onclick="backToCart()" 
                            class="btn btn-light border py-3 rounded-lg fw-semibold">
                        Back to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="cartOverlay" class="cart-overlay" onclick="toggleCart()"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        let cart = [];
        let selectedSupplier = null;

        // Add to cart
        function addToCart(foodId, foodName, price, image, supplierId, businessId) {
            const existingItem = cart.find(i => i.id === foodId);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    id: foodId,
                    name: foodName,
                    price: parseFloat(price),
                    image: image,
                    quantity: 1,
                    supplier_id: supplierId,
                    business_id: businessId
                });
            }
            
            updateCart();
        }
// Function to handle the redirect on click
function redirectToSupplierMenu(supplierId) {
    // 1. Get the base URL from a hidden element or a global variable setup by Blade.
    // Recommended way: Inject the URL structure into a data attribute on a script tag.
    
    // --- Setup in Blade (in your layout/app.blade.php) ---
    /*
    <script>
        window.routes = {
            menuSupplier: "{{ url('supplier') }}/:id/foods" 
        };
    </script>
    */
    // ----------------------------------------------------
    
    // 2. Build the final URL
    if (window.routes && window.routes.menuSupplier) {
        const url = window.routes.menuSupplier.replace(':id', supplierId);
        
        // 3. Perform the redirect
        window.location.href = url;
    } else {
        console.error("Supplier route template not found in window.routes.");
        // Fallback: This URL must match your routes/web.php definition
        window.location.href = `/supplier/${supplierId}/foods`;
    }
}
        // Update cart display
        function updateCart() {
            const cartCount = document.getElementById('cartCount');
            const cartItems = document.getElementById('cartItems');
            const cartTotal = document.getElementById('cartTotal');
            
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            
            cartCount.textContent = totalItems;
            cartTotal.textContent = `TSh ${Math.round(total).toLocaleString()}`;
            
            if (cart.length === 0) {
                cartItems.innerHTML = '<p class="text-secondary text-center py-5">Your cart is empty</p>';
            } else {
                cartItems.innerHTML = cart.map(item => `
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        ${item.image ? `<img src="${item.image}" class="rounded-3 me-3" style="width: 64px; height: 64px; object-fit: cover;">` : '<div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">🍽️</div>'}
                        <div class="flex-grow-1">
                            <h4 class="fw-semibold h6 mb-1">${item.name}</h4>
                            <p class="text-primary fw-bold mb-0">TSh ${Math.round(item.price).toLocaleString()}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <button onclick="updateQuantity(${item.id}, -1)" class="btn btn-sm btn-light rounded-circle border p-0 me-2" style="width: 30px; height: 30px;">-</button>
                            <span class="fw-semibold">${item.quantity}</span>
                            <button onclick="updateQuantity(${item.id}, 1)" class="btn btn-sm btn-primary rounded-circle p-0 ms-2" style="width: 30px; height: 30px; background-color: var(--bs-primary); border-color: var(--bs-primary);">+</button>
                        </div>
                    </div>
                `).join('');
            }
        }

        // Update quantity
        function updateQuantity(foodId, change) {
            const item = cart.find(i => i.id === foodId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    cart = cart.filter(i => i.id !== foodId);
                }
                updateCart();
            }
        }

        // Toggle cart
        function toggleCart() {
            const sidebar = document.getElementById('cartSidebar');
            const overlay = document.getElementById('cartOverlay');
            
            if (sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                overlay.style.display = 'none';
            } else {
                sidebar.classList.add('show');
                overlay.style.display = 'block';
            }
        }

        // Proceed to checkout form
        function proceedToCheckout() {
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }

            // Check if all items are from the same supplier
            const supplierIds = [...new Set(cart.map(item => item.supplier_id))];
            if (supplierIds.length > 1) {
                alert('Please order from one supplier at a time!');
                return;
            }

            // Switch to checkout view
            document.getElementById('cartView').classList.add('d-none');
            document.getElementById('checkoutView').classList.remove('d-none');
            document.getElementById('cartTitle').textContent = 'Checkout';

            // Update checkout summary
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById('checkoutSubtotal').textContent = `TSh ${Math.round(total).toLocaleString()}`;
            document.getElementById('deliveryFee').textContent = 'TSh 0';
            document.getElementById('checkoutTotal').textContent = `TSh ${Math.round(total).toLocaleString()}`;
        }

        // Back to cart
        function backToCart() {
            document.getElementById('checkoutView').classList.add('d-none');
            document.getElementById('cartView').classList.remove('d-none');
            document.getElementById('cartTitle').textContent = 'Your Cart';
        }

        // Close checkout/cart
        function closeCheckout() {
            backToCart();
            toggleCart();
        }
// Ensure 'cart' is accessible globally/in scope
// Ensure the meta tag is present in your HTML: <meta name="csrf-token" content="{{ csrf_token() }}">

function confirmOrder(event) {
    // 1. Critical Fix: Ensure event is available and prevent default browser action (if needed)
    // If you used the inline HTML fix: <button onclick="confirmOrder(event)">
    // If you used the Event Listener fix: (event is automatically passed)
    if (event) {
        // Prevent default form submission if the button were inside a form
        event.preventDefault(); 
    }
    
    const form = document.getElementById('checkoutForm');
    const submitBtn = event ? event.target : document.querySelector('#checkoutView button.btn-custom-orange');
    
    // Form Validation Check
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }
    form.classList.remove('was-validated');

    // Show loading state
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Placing Order...';
    submitBtn.disabled = true;

    // 2. Prepare Customer Data (from form)
    const formData = new FormData(form);
    const orderDetails = {};
    formData.forEach((value, key) => {
        orderDetails[key] = value;
    });

    // 3. Construct the Final Payload for the Laravel Controller
    // The Controller expects all customer fields AND the cart array.
    const payload = {
        ...orderDetails, // full_name, phone, address, region, payment_method, notes
        cart: cart,      // The global 'cart' array containing food details
    };
    
    // Get CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // 4. Send Data to Laravel Backend using Fetch API
    fetch("{{ route('orders.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // Send the CSRF token
        },
        body: JSON.stringify(payload)
    })
    // 5. Handle Response
    .then(response => {
        // Parse the JSON body, regardless of the HTTP status
        return response.json().then(data => ({ status: response.status, body: data }));
    })
    .then(({ status, body }) => {
        if (status === 200 && body.success) {
            // SUCCESS
            alert('Order placed successfully! Order #' + body.order_id);
            
            // Reset state
            cart = [];
            updateCart();
            form.reset();
            backToCart();
            toggleCart();
            
            // Optionally redirect to the order confirmation page
            // if (body.redirect) {
            //     window.location.href = body.redirect; 
            // }

        } else if (status === 422) {
            // LARAVEL VALIDATION ERRORS
            const errorMessages = Object.values(body.errors).flat().join('\n');
            alert('Please correct the following errors:\n' + errorMessages);
        } else {
            // SERVER/GENERAL ERRORS (400, 500)
            alert(body.message || 'An unknown server error occurred.');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Could not connect to the server. Please check your network.');
    })
    .finally(() => {
        // Restore button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}        // Filter by supplier (using food-item's data-supplier attribute)
        function filterBySupplier(supplierId) {
            selectedSupplier = supplierId;
            filterMenu();
        }

        // Filter menu
        function filterMenu() {
            const items = document.querySelectorAll('.food-item');
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const activeCategory = document.querySelector('.category-btn.btn-custom-orange').getAttribute('data-category');
            
            items.forEach(item => {
                const category = item.getAttribute('data-category');
                const supplier = parseInt(item.getAttribute('data-supplier'));
                const foodName = item.querySelector('h6').textContent.toLowerCase(); // Adjusted selector for Bootstrap h6
                
                let showItem = true;
                
                // Category filter
                if (activeCategory !== 'all' && category !== activeCategory) {
                    showItem = false;
                }
                
                // Supplier filter
                if (selectedSupplier && supplier !== selectedSupplier) {
                    showItem = false;
                }
                
                // Search filter
                if (searchTerm && !foodName.includes(searchTerm)) {
                    showItem = false;
                }
                
                item.style.display = showItem ? 'block' : 'none';
            });
        }

        // Category filter logic
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.category-btn').forEach(b => {
                    b.classList.remove('btn-custom-orange');
                    b.classList.add('btn-light', 'text-dark-emphasis');
                });
                this.classList.add('btn-custom-orange');
                this.classList.remove('btn-light', 'text-dark-emphasis');
                
                selectedSupplier = null; // Reset supplier filter when changing category
                filterMenu();
            });
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', filterMenu);

        // Initial cart update
        document.addEventListener('DOMContentLoaded', updateCart);
    </script>
</body>
</html>