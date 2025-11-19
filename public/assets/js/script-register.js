class ElegantPortfolioRegisterForm {
    constructor() {
        this.form = document.getElementById('registerForm');
        this.nimInput = document.getElementById('nim');
        this.nameInput = document.getElementById('name');
        this.daerahInput = document.getElementById('daerah');
        this.organisasiInput = document.getElementById('organisasi');
        this.emailInput = document.getElementById('email');
        this.passwordInput = document.getElementById('password');
        this.passwordConfirmationInput = document.getElementById('password_confirmation');
        this.passwordToggle = document.getElementById('passwordToggle');
        this.passwordConfirmationToggle = document.getElementById('passwordConfirmationToggle');

        this.submitButton = this.form ? this.form.querySelector('.signin-button') : null;
        this.successMessage = document.getElementById('successMessage');
        this.socialButtons = document.querySelectorAll('.social-button');
        this.authDivider = document.querySelector('.auth-divider');
        this.signupPrompt = document.querySelector('.signup-prompt');

        if (this.form) {
            this.init();
        }
    }

    init() {
        this.bindEvents();
        this.setupPasswordToggle();

        if (this.successMessage) {
            this.successMessage.style.display = 'none';
        }
    }

    bindEvents() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        }

        const inputs = [
            this.nimInput,
            this.nameInput,
            this.daerahInput,
            this.organisasiInput,
            this.emailInput,
            this.passwordInput,
            this.passwordConfirmationInput
        ].filter(input => input !== null);

        inputs.forEach(input => {
            if (input) {
                input.addEventListener('blur', () => this.validateField(input));
                input.addEventListener('input', () => this.clearError(input.id));
                input.setAttribute('placeholder', ' ');
            }
        });
    }

    setupPasswordToggle() {
        if (this.passwordToggle && this.passwordInput) {
            this.passwordToggle.addEventListener('click', () => {
                const type = this.passwordInput.type === 'password' ? 'text' : 'password';
                this.passwordInput.type = type;
                this.passwordToggle.classList.toggle('reveal-active', type === 'text');
            });
        }

        if (this.passwordConfirmationToggle && this.passwordConfirmationInput) {
            this.passwordConfirmationToggle.addEventListener('click', () => {
                const type = this.passwordConfirmationInput.type === 'password' ? 'text' : 'password';
                this.passwordConfirmationInput.type = type;
                this.passwordConfirmationToggle.classList.toggle('reveal-active', type === 'text');
            });
        }
    }

    validateField(input) {
        if (!input) return true;

        const value = input.value.trim();
        let errorMessage = '';

        if (!value) {
            errorMessage = `${this.getFieldLabel(input.id)} is required`;
        } else {
            if (input.id === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    errorMessage = 'Please enter a valid email address';
                }
            }
            if (input.id === 'password' && value.length < 6) {
                errorMessage = 'Password must be at least 6 characters long';
            }
            if (input.id === 'password_confirmation' && value !== this.passwordInput?.value) {
                errorMessage = 'Password confirmation does not match';
            }
            if (input.id === 'nim' && !/^\d+$/.test(value)) {
                errorMessage = 'NIM must contain only numbers';
            }
        }

        if (errorMessage) {
            this.showError(input.id, errorMessage);
            return false;
        }

        this.clearError(input.id);
        return true;
    }

    getFieldLabel(fieldId) {
        const labels = {
            'nim': 'NIM',
            'name': 'Name',
            'daerah': 'Daerah',
            'organisasi': 'Organisasi',
            'email': 'Email address',
            'password': 'Password',
            'password_confirmation': 'Password confirmation'
        };
        return labels[fieldId] || fieldId;
    }

    showError(fieldId, message) {
        const formField = document.getElementById(fieldId)?.closest('.form-field');
        const errorElement = document.getElementById(`${fieldId}Error`);

        if (formField && errorElement) {
            formField.classList.add('error');
            errorElement.textContent = message;
            errorElement.classList.add('show');
        }
    }

    clearError(fieldId) {
        const formField = document.getElementById(fieldId)?.closest('.form-field');
        const errorElement = document.getElementById(`${fieldId}Error`);

        if (formField && errorElement) {
            formField.classList.remove('error');
            errorElement.classList.remove('show');
            setTimeout(() => {
                errorElement.textContent = '';
            }, 200);
        }
    }

    async handleSubmit(e) {
        e.preventDefault();

        const inputs = [
            this.nimInput,
            this.nameInput,
            this.daerahInput,
            this.organisasiInput,
            this.emailInput,
            this.passwordInput,
            this.passwordConfirmationInput
        ].filter(input => input !== null);

        let allValid = true;

        inputs.forEach(input => {
            if (!this.validateField(input)) {
                allValid = false;
            }
        });

        if (!allValid) {
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
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        this.showError(field, data.errors[field][0]);
                    });
                } else {
                    this.showError('password', data.message || 'Registration failed');
                }
                this.setLoading(false);
            }
        } catch (error) {
            console.error('Registration error:', error);
            if (error instanceof SyntaxError) {
                this.showSuccess();
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 2000);
            } else {
                this.showError('password', 'Network error. Please try again.');
                this.setLoading(false);
            }
        }
    }

    setLoading(loading) {
        if (this.submitButton) {
            this.submitButton.classList.toggle('loading', loading);
            this.submitButton.disabled = loading;
        }

        if (this.socialButtons) {
            this.socialButtons.forEach(button => {
                button.style.pointerEvents = loading ? 'none' : 'auto';
                button.style.opacity = loading ? '0.6' : '1';
            });
        }
    }

    showSuccess() {
        if (!this.form || !this.successMessage) return;

        console.log('Showing success message');

        this.form.style.transition = 'all 0.4s ease';
        this.form.style.transform = 'scale(0.95)';
        this.form.style.opacity = '0';

        if (this.socialButtons.length > 0) {
            this.socialButtons.forEach(button => {
                button.style.transition = 'all 0.4s ease';
                button.style.opacity = '0';
                button.style.transform = 'scale(0.95)';
            });
        }

        if (this.authDivider) {
            this.authDivider.style.transition = 'all 0.4s ease';
            this.authDivider.style.opacity = '0';
        }

        if (this.signupPrompt) {
            this.signupPrompt.style.transition = 'all 0.4s ease';
            this.signupPrompt.style.opacity = '0';
        }

        setTimeout(() => {
            this.form.style.display = 'none';

            if (this.socialButtons.length > 0) {
                this.socialButtons.forEach(button => {
                    button.style.display = 'none';
                });
            }

            if (this.authDivider) {
                this.authDivider.style.display = 'none';
            }

            if (this.signupPrompt) {
                this.signupPrompt.style.display = 'none';
            }

            this.successMessage.style.display = 'block';

            void this.successMessage.offsetWidth;

            this.successMessage.classList.add('show');
            this.successMessage.style.opacity = '1';
            this.successMessage.style.transform = 'translateY(0)';

        }, 400);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ElegantPortfolioRegisterForm();
});
