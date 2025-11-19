class ElegantPortfolioForgotPasswordForm {
    constructor() {
        this.form = document.getElementById('forgotpasswordform');
        this.emailInput = document.getElementById('email');
        this.emailError = document.getElementById('emailError');
        this.submitButton = this.form.querySelector('.signin-button');
        this.successMessage = document.getElementById('successMessage');

        this.init();
    }

    init() {
        this.bindEvents();
        // Tambahkan placeholder untuk animasi label
        this.emailInput.setAttribute('placeholder', ' ');
    }

    bindEvents() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.emailInput.addEventListener('blur', () => this.validateEmail());
        this.emailInput.addEventListener('input', () => this.clearError('email'));
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
        if (!isEmailValid) {
            return;
        }

        this.setLoading(true);

        try {
            // Simulasi pengiriman reset password email
            await new Promise(resolve => setTimeout(resolve, 2000));

            // Tampilkan success message
            this.showSuccess();
        } catch (error) {
            this.showError('email', 'Failed to send reset email. Please try again.');
        } finally {
            this.setLoading(false);
        }
    }

    setLoading(loading) {
        this.submitButton.classList.toggle('loading', loading);
        this.submitButton.disabled = loading;
    }

    showSuccess() {
        this.form.style.transform = 'scale(0.95)';
        this.form.style.opacity = '0';

        setTimeout(() => {
            this.form.style.display = 'none';
            this.successMessage.classList.add('show');
        }, 300);

        setTimeout(() => {
            console.log('Redirecting after reset request...');
            // window.location.href = '/login';
        }, 3000);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    new ElegantPortfolioForgotPasswordForm();
});
