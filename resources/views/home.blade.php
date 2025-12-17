<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TapEats - Order Your Favorite Food</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.5s ease-out; }
        .cart-badge { animation: pulse 0.3s ease-out; }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold">
                        TE
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">TapEats</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search food..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-500 w-64"
                               id="searchInput">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <button class="relative bg-orange-500 text-white px-6 py-2 rounded-full hover:bg-orange-600 transition" onclick="toggleCart()">
                        <span class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Cart</span>
                            <span class="cart-badge bg-white text-orange-500 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold" id="cartCount">0</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Categories -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex space-x-4 overflow-x-auto">
                <button class="category-btn px-6 py-2 bg-orange-500 text-white rounded-full whitespace-nowrap hover:bg-orange-600 transition" data-category="all">All</button>
                <button class="category-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-full whitespace-nowrap hover:bg-gray-200 transition" data-category="pizza">🍕 Pizza</button>
                <button class="category-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-full whitespace-nowrap hover:bg-gray-200 transition" data-category="burger">🍔 Burgers</button>
                <button class="category-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-full whitespace-nowrap hover:bg-gray-200 transition" data-category="sushi">🍱 Sushi</button>
                <button class="category-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-full whitespace-nowrap hover:bg-gray-200 transition" data-category="dessert">🍰 Desserts</button>
                <button class="category-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-full whitespace-nowrap hover:bg-gray-200 transition" data-category="drinks">🥤 Drinks</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Suppliers Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Popular Suppliers</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="suppliersGrid">
                <!-- Supplier cards will be populated here -->
            </div>
        </div>

        <!-- Menu Items Section -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Menu</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="menuGrid">
                <!-- Menu items will be populated here -->
            </div>
        </div>
    </main>

    <!-- Cart Sidebar -->
    <div id="cartSidebar" class="fixed right-0 top-0 h-full w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">
        <div class="flex flex-col h-full">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold">Your Cart</h3>
                <button onclick="toggleCart()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="cartItems" class="flex-1 overflow-y-auto p-6">
                <p class="text-gray-500 text-center py-8">Your cart is empty</p>
            </div>
            
            <div class="border-t p-6">
                <div class="flex justify-between mb-4">
                    <span class="font-semibold">Total:</span>
                    <span class="font-bold text-xl text-orange-500" id="cartTotal">$0.00</span>
                </div>
                <button class="w-full bg-orange-500 text-white py-3 rounded-lg hover:bg-orange-600 transition font-semibold" onclick="checkout()">
                    Checkout
                </button>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="cartOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" onclick="toggleCart()"></div>

    <script>
        // Sample data (In Laravel, this would come from your controller)
        const suppliers = [
            { id: 1, name: "Pizza Palace", image: "https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400", rating: 4.5, deliveryTime: "25-35 min" },
            { id: 2, name: "Burger House", image: "https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400", rating: 4.7, deliveryTime: "20-30 min" },
            { id: 3, name: "Sushi Master", image: "https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400", rating: 4.8, deliveryTime: "30-40 min" }
        ];

        const menuItems = [
            { id: 1, supplierId: 1, name: "Margherita Pizza", category: "pizza", price: 12.99, image: "https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=400", description: "Classic tomato and mozzarella" },
            { id: 2, supplierId: 2, name: "Cheese Burger", category: "burger", price: 9.99, image: "https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400", description: "Juicy beef patty with cheese" },
            { id: 3, supplierId: 3, name: "Salmon Sushi Roll", category: "sushi", price: 15.99, image: "https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400", description: "Fresh salmon with rice" },
            { id: 4, supplierId: 1, name: "Pepperoni Pizza", category: "pizza", price: 14.99, image: "https://images.unsplash.com/photo-1628840042765-356cda07504e?w=400", description: "Loaded with pepperoni" },
            { id: 5, supplierId: 2, name: "Chicken Burger", category: "burger", price: 10.99, image: "https://images.unsplash.com/photo-1606755962773-d324e0a13086?w=400", description: "Crispy chicken patty" },
            { id: 6, supplierId: 1, name: "Chocolate Cake", category: "dessert", price: 6.99, image: "https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400", description: "Rich chocolate dessert" },
            { id: 7, supplierId: 2, name: "Strawberry Shake", category: "drinks", price: 4.99, image: "https://images.unsplash.com/photo-1572490122747-3968b75cc699?w=400", description: "Creamy strawberry milkshake" },
            { id: 8, supplierId: 3, name: "Tuna Sashimi", category: "sushi", price: 18.99, image: "https://images.unsplash.com/photo-1617196034796-73dfa7b1fd56?w=400", description: "Premium tuna slices" }
        ];

        let cart = [];

        // Render suppliers
        function renderSuppliers() {
            const grid = document.getElementById('suppliersGrid');
            grid.innerHTML = suppliers.map(supplier => `
                <div class="fade-in bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition cursor-pointer">
                    <img src="${supplier.image}" alt="${supplier.name}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2">${supplier.name}</h3>
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>⭐ ${supplier.rating}</span>
                            <span>🕐 ${supplier.deliveryTime}</span>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Render menu items
        function renderMenu(category = 'all', search = '') {
            const grid = document.getElementById('menuGrid');
            let filtered = menuItems;
            
            if (category !== 'all') {
                filtered = filtered.filter(item => item.category === category);
            }
            
            if (search) {
                filtered = filtered.filter(item => 
                    item.name.toLowerCase().includes(search.toLowerCase())
                );
            }

            grid.innerHTML = filtered.map(item => `
                <div class="fade-in bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                    <img src="${item.image}" alt="${item.name}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-1">${item.name}</h3>
                        <p class="text-gray-600 text-sm mb-3">${item.description}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-orange-500">$${item.price}</span>
                            <button onclick="addToCart(${item.id})" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">
                                Add +
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Add to cart
        function addToCart(itemId) {
            const item = menuItems.find(i => i.id === itemId);
            const existingItem = cart.find(i => i.id === itemId);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({ ...item, quantity: 1 });
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
            cartTotal.textContent = `$${total.toFixed(2)}`;
            
            if (cart.length === 0) {
                cartItems.innerHTML = '<p class="text-gray-500 text-center py-8">Your cart is empty</p>';
            } else {
                cartItems.innerHTML = cart.map(item => `
                    <div class="flex items-center space-x-4 mb-4 pb-4 border-b">
                        <img src="${item.image}" class="w-16 h-16 object-cover rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-semibold">${item.name}</h4>
                            <p class="text-orange-500 font-bold">$${item.price}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity(${item.id}, -1)" class="w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                            <span class="font-semibold">${item.quantity}</span>
                            <button onclick="updateQuantity(${item.id}, 1)" class="w-8 h-8 bg-orange-500 text-white rounded-full hover:bg-orange-600">+</button>
                        </div>
                    </div>
                `).join('');
            }
        }

        // Update quantity
        function updateQuantity(itemId, change) {
            const item = cart.find(i => i.id === itemId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    cart = cart.filter(i => i.id !== itemId);
                }
                updateCart();
            }
        }

        // Toggle cart
        function toggleCart() {
            const sidebar = document.getElementById('cartSidebar');
            const overlay = document.getElementById('cartOverlay');
            
            if (sidebar.classList.contains('translate-x-full')) {
                sidebar.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // Checkout
        function checkout() {
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            alert('Proceeding to checkout... (In Laravel, this would redirect to checkout page)');
            // In Laravel: window.location.href = '/checkout';
        }

        // Category filter
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.category-btn').forEach(b => {
                    b.classList.remove('bg-orange-500', 'text-white');
                    b.classList.add('bg-gray-100', 'text-gray-700');
                });
                this.classList.add('bg-orange-500', 'text-white');
                this.classList.remove('bg-gray-100', 'text-gray-700');
                
                const category = this.getAttribute('data-category');
                renderMenu(category, document.getElementById('searchInput').value);
            });
        });

        // Search
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const activeCategory = document.querySelector('.category-btn.bg-orange-500').getAttribute('data-category');
            renderMenu(activeCategory, e.target.value);
        });

        // Initialize
        renderSuppliers();
        renderMenu();
    </script>
</body>
</html>