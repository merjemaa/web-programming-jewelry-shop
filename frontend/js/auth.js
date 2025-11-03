class Auth {
    constructor() {
        this.currentUser = this.getCurrentUser();
    }

    getCurrentUser() {
        return JSON.parse(localStorage.getItem('aura_jewels_user') || 'null');
    }

    async login(email, password) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                if (email && password.length >= 6) {
                    const user = {
                        id: 1,
                        email: email,
                        name: email.split('@')[0],
                        role: 'customer'
                    };
                    
                    localStorage.setItem('aura_jewels_user', JSON.stringify(user));
                    localStorage.setItem('aura_jewels_token', 'mock_jwt_token_here');
                    
                    this.currentUser = user;
                    resolve(user);
                } else {
                    reject(new Error('Invalid credentials. Please check your email and password.'));
                }
            }, 1000);
        });
    }

    async register(name, email, password, confirmPassword) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                if (password !== confirmPassword) {
                    reject(new Error('Passwords do not match'));
                    return;
                }
                
                if (password.length < 6) {
                    reject(new Error('Password must be at least 6 characters'));
                    return;
                }

                const user = {
                    id: Date.now(),
                    name: name,
                    email: email,
                    role: 'customer'
                };
                
                localStorage.setItem('aura_jewels_user', JSON.stringify(user));
                localStorage.setItem('aura_jewels_token', 'mock_jwt_token_here');
                
                this.currentUser = user;
                resolve(user);
            }, 1000);
        });
    }

    logout() {
        localStorage.removeItem('aura_jewels_user');
        localStorage.removeItem('aura_jewels_token');
        this.currentUser = null;
        window.location.hash = 'home';
    }

    isAuthenticated() {
        return this.currentUser !== null;
    }

    isAdmin() {
        return this.currentUser && this.currentUser.role === 'admin';
    }
}

const auth = new Auth();

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            const submitBtn = loginForm.querySelector('button[type="submit"]');
            
            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Logging in...';
                
                await auth.login(email, password);
                
                if (window.app) {
                    window.app.showAlert('Login successful!', 'success');
                    window.app.updateAuthUI(true);
                }
                window.location.hash = 'home';
                
            } catch (error) {
                if (window.app) {
                    window.app.showAlert(error.message, 'danger');
                }
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Login';
            }
        });
    }

    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const name = document.getElementById('register-name').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('register-confirm-password').value;
            const submitBtn = registerForm.querySelector('button[type="submit"]');
            
            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Creating account...';
                
                await auth.register(name, email, password, confirmPassword);
                
                if (window.app) {
                    window.app.showAlert('Account created successfully!', 'success');
                    window.app.updateAuthUI(true);
                }
                window.location.hash = 'home';
                
            } catch (error) {
                if (window.app) {
                    window.app.showAlert(error.message, 'danger');
                }
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Create Account';
            }
        });
    }
});