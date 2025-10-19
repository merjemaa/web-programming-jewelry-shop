class Router {
    constructor() {
        this.routes = {};
        this.currentRoute = '';
        this.appElement = document.getElementById('app-content');
        
        // Bind events
        window.addEventListener('hashchange', this.handleRouteChange.bind(this));
        document.addEventListener('DOMContentLoaded', this.handleRouteChange.bind(this));
        document.addEventListener('click', this.handleLinkClick.bind(this));
    }

    addRoute(path, template) {
        this.routes[path] = template;
    }

    async handleRouteChange() {
        const hash = window.location.hash.slice(1) || 'home';
        this.currentRoute = hash;
        
        await this.loadView(hash);
        this.updateActiveLink();
    }

    async loadView(viewName) {
        try {
            // Show loading state
            this.appElement.classList.add('loading');
            
            // If it's home route, we already have content in index.html
            if (viewName === 'home') {
                // For home, we'll use the content already in index.html
                this.showHomeContent();
            } else {
                // Load the view HTML for other pages
                const response = await fetch(`views/${viewName}.html`);
                if (!response.ok) throw new Error('View not found');
                
                const html = await response.text();
                this.appElement.innerHTML = html;
            }
            
            // Remove loading state and add animation
            this.appElement.classList.remove('loading');
            this.appElement.classList.add('fade-in');
            
            // Initialize view-specific JavaScript
            this.initializeView(viewName);
            
            // Remove animation class after animation completes
            setTimeout(() => {
                this.appElement.classList.remove('fade-in');
            }, 500);
            
        } catch (error) {
            console.error('Error loading view:', error);
            this.showHomeContent(); // Fallback to home
        }
    }

    showHomeContent() {
        // Home content is already in index.html, so we just need to show it
        this.appElement.innerHTML = `
            <section class="hero-section">
                <div class="container">
                    <div class="row align-items-center min-vh-100">
                        <div class="col-lg-6">
                            <h1 class="display-3 fw-bold mb-4">Discover Timeless Elegance</h1>
                            <p class="lead mb-4">Exquisite jewelry pieces crafted with precision and passion. Each piece tells a story of luxury and sophistication.</p>
                            <a href="#products" class="btn btn-light btn-lg me-3" data-link>Shop Collection</a>
                            <a href="#about" class="btn btn-outline-light btn-lg" data-link>Learn More</a>
                        </div>
                        <div class="col-lg-6 text-center">
                            <div class="hero-image-placeholder bg-white rounded shadow p-5">
                                <i class="bi bi-gem display-1 text-primary"></i>
                                <p class="mt-3">Luxury Jewelry Collection</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-5 bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center mb-5">
                            <h2 class="display-5 fw-bold">Featured Collections</h2>
                            <p class="lead">Discover our most popular jewelry pieces</p>
                        </div>
                    </div>
                    <div class="row g-4" id="featured-products">
                        <div class="col-md-4">
                            <div class="card product-card h-100">
                                <div class="card-image-placeholder bg-secondary bg-opacity-10 p-5 text-center">
                                    <i class="bi bi-diamond display-4 text-primary"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Diamond Collection</h5>
                                    <p class="card-text">Exquisite diamond pieces that sparkle with elegance.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price">From $299</span>
                                        <a href="#products" class="btn btn-primary" data-link>View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card product-card h-100">
                                <div class="card-image-placeholder bg-secondary bg-opacity-10 p-5 text-center">
                                    <i class="bi bi-gem display-4 text-primary"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Gold Masterpieces</h5>
                                    <p class="card-text">Luxurious gold jewelry crafted to perfection.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price">From $199</span>
                                        <a href="#products" class="btn btn-primary" data-link>View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card product-card h-100">
                                <div class="card-image-placeholder bg-secondary bg-opacity-10 p-5 text-center">
                                    <i class="bi bi-circle display-4 text-primary"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Silver Elegance</h5>
                                    <p class="card-text">Beautiful silver pieces for everyday luxury.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price">From $99</span>
                                        <a href="#products" class="btn btn-primary" data-link>View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        `;
    }

    initializeView(viewName) {
        // Initialize view-specific functionality
        switch(viewName) {
            case 'products':
                this.initializeProducts();
                break;
            case 'cart':
                this.initializeCart();
                break;
            case 'login':
            case 'register':
                this.initializeAuth();
                break;
        }
    }

    initializeProducts() {
        // Product filtering and search functionality
        const searchInput = document.getElementById('product-search');
        const filterButtons = document.querySelectorAll('.filter-btn');
        
        if (searchInput) {
            searchInput.addEventListener('input', this.filterProducts.bind(this));
        }
        
        if (filterButtons) {
            filterButtons.forEach(btn => {
                btn.addEventListener('click', this.handleFilterClick.bind(this));
            });
        }
    }

    initializeCart() {
        // Cart functionality
        if (typeof cart !== 'undefined') {
            cart.displayCartItems();
        }
    }

    initializeAuth() {
        // Auth forms are handled by auth.js
        console.log('Auth view initialized');
    }

    handleLinkClick(e) {
        if (e.target.matches('[data-link]')) {
            e.preventDefault();
            const href = e.target.getAttribute('href');
            if (href.startsWith('#')) {
                window.location.hash = href;
            }
        }
    }

    updateActiveLink() {
        // Remove active class from all links
        document.querySelectorAll('[data-link]').forEach(link => {
            link.classList.remove('active-link');
        });
        
        // Add active class to current route link
        const currentLink = document.querySelector(`[href="#${this.currentRoute}"]`);
        if (currentLink) {
            currentLink.classList.add('active-link');
        }
    }

    filterProducts(e) {
        const searchTerm = e.target.value.toLowerCase();
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const description = card.querySelector('.card-text').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    handleFilterClick(e) {
        e.preventDefault();
        const filter = e.target.dataset.filter;
        
        // Update active filter button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        e.target.classList.add('active');
        
        // Filter products
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            if (filter === 'all') {
                card.style.display = 'block';
            } else {
                // Simple filter based on product title
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                if (title.includes(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }
}

// Initialize router
const router = new Router();

// Define routes
router.addRoute('home', 'home');
router.addRoute('about', 'about');
router.addRoute('products', 'products');
router.addRoute('login', 'login');
router.addRoute('register', 'register');
router.addRoute('contact', 'contact');
router.addRoute('cart', 'cart');