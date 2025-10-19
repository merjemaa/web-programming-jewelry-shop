// Main application initialization
class App {
    constructor() {
        this.init();
    }

    init() {
        // Initialize any global functionality
        this.setupEventListeners();
        this.checkAuthStatus();
    }

    setupEventListeners() {
        // Global event listeners
        document.addEventListener('click', this.handleGlobalClicks.bind(this));
    }

    handleGlobalClicks(e) {
        // Handle add to cart buttons
        if (e.target.classList.contains('add-to-cart') || e.target.closest('.add-to-cart')) {
            e.preventDefault();
            const button = e.target.classList.contains('add-to-cart') ? e.target : e.target.closest('.add-to-cart');
            this.handleAddToCart(button);
        }
    }

    handleAddToCart(button) {
        const productId = button.dataset.productId;
        const productName = button.dataset.productName;
        const productPrice = parseFloat(button.dataset.productPrice);
        const productImage = button.dataset.productImage || 'assets/images/default-product.jpg';

        if (cart) {
            cart.addItem(productId, productName, productPrice, productImage);
            
            // Show success message
            this.showAlert('Product added to cart!', 'success');
        }
    }

    showAlert(message, type = 'info') {
        // Remove existing alert if any
        const existingAlert = document.querySelector('.alert-message');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-message`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }

    checkAuthStatus() {
        // Check if user is logged in (for future backend integration)
        const token = localStorage.getItem('aura_jewels_token');
        if (token) {
            this.updateAuthUI(true);
        } else {
            this.updateAuthUI(false);
        }
    }

    updateAuthUI(isLoggedIn) {
        const authSection = document.querySelector('.navbar-nav .ms-auto');
        if (!authSection) return;

        if (isLoggedIn) {
            const user = JSON.parse(localStorage.getItem('aura_jewels_user') || '{}');
            authSection.innerHTML = `
                <li class="nav-item">
                    <span class="nav-link">Welcome, ${user.name}</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#profile" data-link>Profile</a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-outline-danger ms-2" id="logout-btn">Logout</button>
                </li>
            `;
            
            document.getElementById('logout-btn').addEventListener('click', this.handleLogout.bind(this));
        } else {
            authSection.innerHTML = `
                <a href="#cart" class="btn btn-outline-dark position-relative me-3" data-link>
                    <i class="bi bi-cart3"></i> Cart
                    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge bg-danger">0</span>
                </a>
                <a href="#login" class="btn btn-outline-primary me-2" data-link>Login</a>
                <a href="#register" class="btn btn-primary" data-link>Register</a>
            `;
        }
    }

    handleLogout() {
        localStorage.removeItem('aura_jewels_token');
        localStorage.removeItem('aura_jewels_user');
        this.updateAuthUI(false);
        window.location.hash = 'home';
        this.showAlert('Logged out successfully', 'info');
    }
}

// Initialize app when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.app = new App();
});