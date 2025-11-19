class ElegantPortfolioLoginForm {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.emailInput = document.getElementById('email');
        this.passwordInput = document.getElementById('password');
        this.passwordToggle = document.getElementById('passwordToggle');
        this.submitButton = this.form.querySelector('.signin-button');
        this.successMessage = document.getElementById('successMessage');
        this.socialButtons = document.querySelectorAll('.social-button');

        this.init();
    }

    init() {
        this.bindEvents();
        this.setupPasswordToggle();
        this.setupSocialButtons();
    }

    bindEvents() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.emailInput.addEventListener('blur', () => this.validateEmail());
        this.passwordInput.addEventListener('blur', () => this.validatePassword());
        this.emailInput.addEventListener('input', () => this.clearError('email'));
        this.passwordInput.addEventListener('input', () => this.clearError('password'));

        this.emailInput.setAttribute('placeholder', ' ');
        this.passwordInput.setAttribute('placeholder', ' ');
    }

    setupPasswordToggle() {
        this.passwordToggle.addEventListener('click', () => {
            const type = this.passwordInput.type === 'password' ? 'text' : 'password';
            this.passwordInput.type = type;

            this.passwordToggle.classList.toggle('reveal-active', type === 'text');
        });
    }

    setupSocialButtons() {
        this.socialButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const provider = button.textContent.trim();
                this.handleSocialLogin(provider, button);
            });
        });
    }

    validateEmail() {
        const email = this.emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email) {
            this.showError('email', 'Email address is required');
            return false;
        }

        if (!emailRegex.test(email)) {
            this.showError('email', 'Please enter a valid email address');
            return false;
        }

        this.clearError('email');
        return true;
    }

    validatePassword() {
        const password = this.passwordInput.value;

        if (!password) {
            this.showError('password', 'Password is required');
            return false;
        }

        if (password.length < 6) {
            this.showError('password', 'Password must be at least 6 characters long');
            return false;
        }

        this.clearError('password');
        return true;
    }

    showError(field, message) {
        const formField = document.getElementById(field).closest('.form-field');
        const errorElement = document.getElementById(`${field}Error`);

        formField.classList.add('error');
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }

    clearError(field) {
        const formField = document.getElementById(field).closest('.form-field');
        const errorElement = document.getElementById(`${field}Error`);

        formField.classList.remove('error');
        errorElement.classList.remove('show');
        setTimeout(() => {
            errorElement.textContent = '';
        }, 200);
    }

    async handleSubmit(e) {
        e.preventDefault();

        const isEmailValid = this.validateEmail();
        const isPasswordValid = this.validatePassword();

        if (!isEmailValid || !isPasswordValid) {
            return;
        }

        this.setLoading(true);

        try {
            const formData = new FormData(this.form);

            const response = await fetch(this.form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                this.showSuccess();
                setTimeout(() => {
                    window.location.href = data.redirect || '/dashboard';
                }, 2000);
            } else {
                this.showError('password', data.message || 'Login failed');
            }
        } catch (error) {
            console.error('Login error:', error);
            if (error instanceof SyntaxError) {
                console.log('Server redirected - login successful');
                this.showSuccess();
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 1000);
            } else {
                this.showError('password', 'Network error. Please try again.');
            }
        } finally {
            this.setLoading(false);
        }
    }

    async handleSocialLogin(provider, button) {
        console.log(`Signing in with ${provider}...`);

        const originalHTML = button.innerHTML;
        button.style.pointerEvents = 'none';
        button.style.opacity = '0.7';
        button.innerHTML = `
            <div style="width: 16px; height: 16px; border: 2px solid #cbd5e0; border-top: 2px solid #4a5568; border-radius: 50%; animation: spin 1s linear infinite;"></div>
            Connecting...
        `;

        try {
            await new Promise(resolve => setTimeout(resolve, 1800));
            window.location.href = '/auth/redirect';
        } catch (error) {
            console.error(`${provider} sign in failed: ${error.message}`);
            button.innerHTML = originalHTML;
            button.style.pointerEvents = 'auto';
            button.style.opacity = '1';
        }
    }

    setLoading(loading) {
        this.submitButton.classList.toggle('loading', loading);
        this.submitButton.disabled = loading;

        this.socialButtons.forEach(button => {
            button.style.pointerEvents = loading ? 'none' : 'auto';
            button.style.opacity = loading ? '0.6' : '1';
        });
    }

    showSuccess() {
        this.form.style.transform = 'scale(0.95)';
        this.form.style.opacity = '0';

        setTimeout(() => {
            this.form.style.display = 'none';
            const elementsToHide = document.querySelectorAll('.social-auth, .signup-prompt, .auth-divider');
            elementsToHide.forEach(el => el.style.display = 'none');

            this.successMessage.classList.add('show');
        }, 300);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ElegantPortfolioLoginForm();
});
