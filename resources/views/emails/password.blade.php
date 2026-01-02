<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Car Rental Kolkata</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;600;700&display=swap');
        
        body {
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
            font-family: 'Poppins', Arial, sans-serif;
        }
        
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #e8ebf1;
        }
        
        .header {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .header:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 20px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='1' d='M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
        }
        
        .logo {
            font-family: 'Montserrat', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin: 0;
            letter-spacing: 1px;
        }
        
        .logo span {
            font-weight: 300;
        }
        
        .welcome-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 24px;
            border-radius: 50px;
            margin-top: 15px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            backdrop-filter: blur(10px);
        }
        
        .content {
            padding: 50px 40px 40px;
        }
        
        .greeting {
            font-size: 28px;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 10px;
        }
        
        .user-name {
            color: #43e97b;
            font-weight: 700;
        }
        
        .message {
            color: #636e72;
            line-height: 1.8;
            font-size: 16px;
            margin-bottom: 30px;
        }
        
        .credentials-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            border-left: 5px solid #43e97b;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        }
        
        .credentials-title {
            font-size: 14px;
            font-weight: 600;
            color: #43e97b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        
        .password-display {
            background: white;
            border: 2px dashed #e8ebf1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        
        .password {
            font-family: 'Courier New', monospace;
            font-size: 24px;
            font-weight: 700;
            color: #2d3436;
            letter-spacing: 2px;
            padding: 10px;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .security-note {
            display: flex;
            align-items: flex-start;
            background: #fff9e6;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            border-left: 4px solid #ffd166;
        }
        
        .security-icon {
            color: #ff9f1c;
            margin-right: 15px;
            font-size: 20px;
        }
        
        .security-note p {
            margin: 0;
            color: #8a7d30;
            font-size: 14px;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            padding: 16px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 5px 20px rgba(67, 233, 123, 0.3);
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 233, 123, 0.4);
        }
        
        .steps-container {
            display: flex;
            justify-content: space-between;
            margin: 40px 0;
            flex-wrap: wrap;
        }
        
        .step {
            flex: 1;
            min-width: 150px;
            text-align: center;
            padding: 20px;
            margin: 10px;
        }
        
        .step-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }
        
        .step-title {
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 8px;
        }
        
        .step-desc {
            color: #636e72;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .footer {
            background: #2d3436;
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-link {
            display: inline-block;
            margin: 0 10px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-decoration: none;
            color: white;
            line-height: 40px;
            transition: all 0.3s;
        }
        
        .social-link:hover {
            background: #43e97b;
            transform: translateY(-3px);
        }
        
        .company-info {
            font-size: 14px;
            color: #b2bec3;
            line-height: 1.6;
        }
        
        .regards {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin: 20px 0;
        }
        
        .signature {
            color: #43e97b;
            font-weight: 700;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .steps-container {
                flex-direction: column;
            }
            
            .step {
                min-width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="header">
            <h1 class="logo">CAR<span>RENTAL</span></h1>
            <div class="welcome-badge">KOLKATA</div>
        </div>
        
        <!-- Main Content -->
        <div class="content">
            <h2 class="greeting">Hello <span class="user-name">{{ $userName }}</span>,</h2>
            
            <p class="message">
                Welcome to Car Rental Kolkata! We're thrilled to have you on board. 
                Your account has been successfully created and is ready to use.
            </p>
            
            <!-- Credentials Box -->
            <div class="credentials-box">
                <div class="credentials-title">Your Login Credentials</div>
                <p class="message">Use the following password to access your account:</p>
                
                <div class="password-display">
                    <div class="password">{{ $password }}</div>
                </div>
                
                <div class="security-note">
                    <div class="security-icon">🔒</div>
                    <p>
                        <strong>Security Tip:</strong> For your security, we recommend changing this password 
                        after your first login. Keep your credentials confidential and never share them with anyone.
                    </p>
                </div>
            </div>
            
            <!-- CTA Button -->
            <div style="text-align: center;">
                <a href="https://carrentalkolkata.com/login" class="cta-button">
                    🚗 Login to Your Account
                </a>
            </div>
            
            <!-- Steps to Get Started -->
            <div class="steps-container">
                <div class="step">
                    <div class="step-icon">1</div>
                    <div class="step-title">Login Securely</div>
                    <div class="step-desc">Use your email and the provided password</div>
                </div>
                
                <div class="step">
                    <div class="step-icon">2</div>
                    <div class="step-title">Update Profile</div>
                    <div class="step-desc">Complete your profile for faster bookings</div>
                </div>
                
                <div class="step">
                    <div class="step-icon">3</div>
                    <div class="step-title">Start Booking</div>
                    <div class="step-desc">Browse our fleet and book your first ride</div>
                </div>
            </div>
            
            <p class="message">
                Need help? Our support team is available 24/7 to assist you with any questions 
                or concerns. You can reach us at info.carrentalkolkata@gmail.com or call +91 9073740000.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="regards">Best Regards,</div>
            <div class="signature">Car Rental Kolkata Team</div>
            
            <div class="social-links">
                <a href="#" class="social-link">f</a>
                <a href="#" class="social-link">t</a>
                <a href="#" class="social-link">in</a>
                <a href="#" class="social-link">ig</a>
            </div>
            
            <div class="company-info">
                Car Rental Kolkata Pvt. Ltd.<br>
                123 Park Street, Kolkata - 700016, West Bengal<br>
                Phone: +91 99999 99999 | Email: info.carrentalkolkata@gmail.com<br>
                <br>
                © 2025 Car Rental Kolkata. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>