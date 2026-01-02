<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login | Your App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --secondary-color: #7209b7;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
            --success-color: #4cc9f0;
            --error-color: #f72585;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 0;
            margin: 0;
        }
        
        .login-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .login-wrapper {
            display: flex;
            min-height: 700px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }
        
        .login-image {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,170.7C960,160,1056,160,1152,170.7C1248,181,1344,203,1392,213.3L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: center bottom;
        }
        
        .image-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 500px;
        }
        
        .image-content h2 {
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 2.2rem;
        }
        
        .image-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .features-list {
            text-align: left;
            margin-top: 40px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .feature-icon {
            background: rgba(255, 255, 255, 0.2);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .login-form {
            flex: 1;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 50px;
        }
        
        .form-header {
            margin-bottom: 40px;
        }
        
        .form-header h3 {
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 10px;
        }
        
        .form-header p {
            color: #6c757d;
            margin: 0;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark-text);
            margin-bottom: 8px;
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e1e5ee;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #e1e5ee;
            border-right: none;
        }
        
        .password-toggle {
            cursor: pointer;
            background-color: #f8f9fa;
            border: 1px solid #e1e5ee;
            border-left: none;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }
        
        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e1e5ee;
        }
        
        .divider-text {
            padding: 0 15px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .social-login {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .btn-social {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-google {
            background-color: white;
            color: #757575;
            border: 1px solid #e1e5ee;
        }
        
        .btn-google:hover {
            background-color: #f8f9fa;
            border-color: #d1d5db;
        }
        
        .btn-facebook {
            background-color: #1877f2;
            color: white;
            border: 1px solid #1877f2;
        }
        
        .btn-facebook:hover {
            background-color: #166fe5;
            border-color: #166fe5;
        }
        
        .additional-options {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        
        .additional-options a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .additional-options a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: none;
        }
        
        .alert-danger {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
        }
        
        .alert-success {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        .password-strength {
            height: 4px;
            background-color: #e9ecef;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s, background-color 0.3s;
        }
        
        .strength-weak {
            background-color: #f72585;
            width: 33%;
        }
        
        .strength-medium {
            background-color: #f8961e;
            width: 66%;
        }
        
        .strength-strong {
            background-color: #4cc9f0;
            width: 100%;
        }
        
        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                min-height: auto;
            }
            
            .login-image {
                padding: 40px 20px;
            }
            
            .login-form {
                padding: 40px 30px;
            }
        }
        
        @media (max-width: 576px) {
            .login-form {
                padding: 30px 20px;
            }
            
            .social-login {
                flex-direction: column;
            }
            
            .additional-options {
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-wrapper">
            <!-- Left Side - Image and Content -->
            <div class="login-image">
                <div class="image-content">
                    <h2>Welcome Back!</h2>
                    <p>Sign in to access your personalized dashboard and continue your journey with us.</p>
                    
                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h5>Enterprise Security</h5>
                                <p>Your data is protected with bank-level encryption</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div>
                                <h5>Lightning Fast</h5>
                                <p>Experience blazing fast performance</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-sync"></i>
                            </div>
                            <div>
                                <h5>Always in Sync</h5>
                                <p>Your data syncs across all your devices</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Login Form -->
            <div class="login-form">
                <div class="form-header">
                    <h3><i class="fas fa-lock me-2"></i>Secure Login</h3>
                    <p>Access your account to continue</p>
                </div>
                
                <!-- Success message (example) -->
                <!-- <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> Your password has been updated successfully.
                </div> -->
                
                <!-- Error message (example) -->
                <!-- <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> Invalid email or password.
                </div> -->
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
                    </div>
                @endif
                
                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                            <span class="input-group-text password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <div class="password-strength mt-2">
                            <div class="password-strength-bar" id="passwordStrength"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i> Sign In
                        </button>
                    </div>
                </form>
                
                <div class="divider">
                    <span class="divider-text">Or continue with</span>
                </div>
                
                <div class="social-login">
                    <button type="button" class="btn btn-google">
                        <i class="fab fa-google"></i> Google
                    </button>
                    <button type="button" class="btn btn-facebook">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </button>
                </div>
                
                <div class="additional-options">
                    <a href="#"><i class="fas fa-key me-1"></i> Forgot password?</a>
                    <a href="#"><i class="fas fa-user-plus me-1"></i> Create account</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Password strength indicator (example)
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            
            // Reset classes
            strengthBar.className = 'password-strength-bar';
            
            if (password.length === 0) {
                strengthBar.style.width = '0';
                return;
            }
            
            // Simple password strength calculation
            let strength = 0;
            if (password.length >= 6) strength += 1;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
            if (password.match(/\d/)) strength += 1;
            if (password.match(/[^a-zA-Z\d]/)) strength += 1;
            
            // Update strength bar
            if (strength <= 1) {
                strengthBar.classList.add('strength-weak');
            } else if (strength <= 2) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        });
    </script>
</body>
</html>