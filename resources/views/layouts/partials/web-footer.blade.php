
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

<footer class="bg-light py-4 mt-5 border-top">
    <div class="container-fluid container-xxl text-center text-muted small">
        &copy; {{ date('Y') }} {{ config('app.name', 'FoodApp') }}. All rights reserved.
    </div>
</footer>