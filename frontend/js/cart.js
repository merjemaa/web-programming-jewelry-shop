class Cart {
    constructor() {
        this.items = this.loadCart();
        this.updateCartCount();
    }

    loadCart() {
        const cart = localStorage.getItem('aura_jewels_cart');
        return cart ? JSON.parse(cart) : [];
    }

    saveCart() {
        localStorage.setItem('aura_jewels_cart', JSON.stringify(this.items));
        this.updateCartCount();
    }

    addItem(id, name, price, image, quantity = 1) {
        const existingItem = this.items.find(item => item.id === id);
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            this.items.push({
                id,
                name,
                price,
                image,
                quantity
            });
        }
        
        this.saveCart();
        this.updateCartCount();
    }

    removeItem(id) {
        this.items = this.items.filter(item => item.id !== id);
        this.saveCart();
        this.updateCartCount();
        
        // If we're on the cart page, refresh the display
        if (window.location.hash === '#cart') {
            this.displayCartItems();
        }
    }

    updateQuantity(id, quantity) {
        const item = this.items.find(item => item.id === id);
        if (item) {
            if (quantity <= 0) {
                this.removeItem(id);
            } else {
                item.quantity = quantity;
                this.saveCart();
                this.updateCartCount();
                
                // If we're on the cart page, refresh the display
                if (window.location.hash === '#cart') {
                    this.displayCartItems();
                }
            }
        }
    }

    clearCart() {
        this.items = [];
        this.saveCart();
        this.updateCartCount();
        
        // If we're on the cart page, refresh the display
        if (window.location.hash === '#cart') {
            this.displayCartItems();
        }
        
        if (window.app) {
            window.app.showAlert('Cart cleared successfully', 'info');
        }
    }

    getTotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    getItemCount() {
        return this.items.reduce((count, item) => count + item.quantity, 0);
    }

    updateCartCount() {
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            const count = this.getItemCount();
            cartCount.textContent = count;
            cartCount.style.display = count > 0 ? 'block' : 'none';
        }
    }

    displayCartItems() {
        const cartContainer = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const cartSubtotal = document.getElementById('cart-subtotal');
        
        if (!cartContainer) return;

        if (this.items.length === 0) {
            cartContainer.innerHTML = `
                <div class="text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted"></i>
                    <h4 class="mt-3">Your cart is empty</h4>
                    <p class="text-muted">Browse our collection and add some beautiful jewelry!</p>
                    <a href="#products" class="btn btn-primary mt-3" data-link>Shop Now</a>
                </div>
            `;
            if (cartTotal) cartTotal.textContent = '$0.00';
            if (cartSubtotal) cartSubtotal.textContent = '$0.00';
            return;
        }

        let html = '';
        let subtotal = 0;

        this.items.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            html += `
                <div class="cart-item row align-items-center">
                    <div class="col-md-2">
                        <div class="bg-light rounded p-2 text-center">
                            <i class="bi bi-gem text-primary fs-2"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 class="mb-1">${item.name}</h6>
                        <p class="text-muted mb-0">$${item.price.toFixed(2)}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="quantity-controls d-flex align-items-center">
                            <button class="quantity-btn" onclick="cart.updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                            <input type="text" class="quantity-input" value="${item.quantity}" readonly>
                            <button class="quantity-btn" onclick="cart.updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <strong>$${itemTotal.toFixed(2)}</strong>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-outline-danger btn-sm" onclick="cart.removeItem('${item.id}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        cartContainer.innerHTML = html;
        
        if (cartTotal) cartTotal.textContent = `$${subtotal.toFixed(2)}`;
        if (cartSubtotal) cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
    }

    checkout() {
        if (this.items.length === 0) {
            if (window.app) {
                window.app.showAlert('Your cart is empty!', 'warning');
            }
            return;
        }

        // In a real application, this would redirect to a checkout page
        // or send the cart data to a backend
        if (window.app) {
            window.app.showAlert(`Proceeding to checkout with ${this.getItemCount()} items. Total: $${this.getTotal().toFixed(2)}`, 'info');
        }
        
        // For demo purposes, we'll clear the cart after "checkout"
        setTimeout(() => {
            this.clearCart();
        }, 2000);
    }
}

// Initialize cart
const cart = new Cart();