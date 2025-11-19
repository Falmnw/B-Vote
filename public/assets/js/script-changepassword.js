class ElegantPortfolioChangePasswordForm {
    constructor() {
        this.form = document.getElementById('changepasswordform');
        this.newPasswordInput = document.getElementById('newPassword');
        this.passwordConfirmationInput = document.getElementById('newPasswordConfirmation');
        this.newPasswordToggle = document.getElementById('newPasswordToggle');
        this.passwordConfirmationToggle = document.getElementById('newPasswordConfirmationToggle');
        this.submitButton = this.form.querySelector('.signin-button');
        this.successMessage = document.getElementById('successMessage');

        this.init();
    }

    init() {
        this.bindEvents();
        this.setupPasswordToggle(this.newPasswordInput, this.newPasswordToggle);
        this.setupPasswordToggle(this.passwordConfirmationInput, this.passwordConfirmationToggle);
    }

    bindEvents() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));

        this.newPasswordInput.addEventListener('blur', () => this.validateNewPassword());
        this.passwordConfirmationInput.addEventListener('blur', () => this.validatePasswordConfirmation());

        this.newPasswordInput.addEventListener('input', () => this.clearError('newPassword'));
        this.passwordConfirmationInput.addEventListener('input', () => this.clearError('passwordConfirmation'));

        // Placeholder untuk animasi label
        this.newPasswordInput.setAttribute('placeholder', ' ');
        this.passwordConfirmationInput.setAttribute('placeholder', ' ');
    }

    setupPasswordToggle(input, toggleButton) {
        toggleButton.addEventListener('click', () => {
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;

            toggleButton.classList.toggle('reveal-active', type === 'text');
        });
    }

    validateNewPassword() {
        const password = this.newPasswordInput.value.trim();

        if (!password) {
            this.showError('newPassword', 'New password is required');
            return false;
        }

        if (password.length < 6) {
            this.showError('newPassword', 'Password must be at least 6 characters long');
            return false;
        }

        this.clearError('newPassword');
        return true;
    }

    validatePasswordConfirmation() {
        const confirm = this.passwordConfirmationInput.value.trim();
        const password = this.newPasswordInput.value.trim();

        if (!confirm) {
            this.showError('passwordConfirmation', 'Please confirm your password');
            return false;
        }

        if (confirm !== password) {
            this.showError('passwordConfirmation', 'Passwords do not match');
            return false;
        }

        this.clearError('passwordConfirmation');
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

        const isPasswordValid = this.validateNewPassword();
        const isConfirmationValid = this.validatePasswordConfirmation();

        if (!isPasswordValid || !isConfirmationValid) {
            return;
        }

        this.setLoading(true);

        try {
            // Simulasi proses update password
            await new Promise(resolve => setTimeout(resolve, 2000));

            // Show success state
            this.showSuccess();
        } catch (error) {
            this.showError('newPassword', 'Password change failed. Please try again.');
        } finally {
            this.setLoading(false);
        }
    }

    setLoading(loading) {
        this.submitButton.classList.toggle('loading', loading);
        this.submitButton.disabled = loading;
    }

    showSuccess() {
        // Hide form
        this.form.style.transform = 'scale(0.95)';
        this.form.style.opacity = '0';

        setTimeout(() => {
            this.form.style.display = 'none';
            this.successMessage.classList.add('show');
        }, 300);

        // Redirect after success
        setTimeout(() => {
            console.log('Redirecting to login page...');
            // window.location.href = '/login';
        }, 3000);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    new ElegantPortfolioChangePasswordForm();
});
