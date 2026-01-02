<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f7fa;
            padding: 0;
            margin: 0;
        }
        
        .email-container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
        }
        
        /* Header Banner */
        .safety-banner {
            background: linear-gradient(135deg, #022455 0%, #022455 100%);
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .safety-banner h1 {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }
        
        .safety-banner::before {
            content: '🚗';
            position: absolute;
            font-size: 60px;
            opacity: 0.1;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        /* Email Header */
        .email-header {
            padding: 30px;
            background: #ffffff;
            border-bottom: 1px solid #e9ecef;
        }
        
        .sender-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .company-logo {
            font-size: 24px;
            font-weight: 800;
            color: #022455;
            letter-spacing: 1px;
        }
        
        .sender-email {
            color: #666;
            font-size: 14px;
        }
        
        /* Main Content */
        .email-content {
            padding: 30px;
        }
        
        .greeting-section {
            margin-bottom: 25px;
        }
        
        .greeting {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .booking-summary {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #022455;
        }
        
        .booking-id {
            color: #022455;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .booking-id::before {
            content: '🎫';
        }
        
        .route-details {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .route-highlight {
            color: #022455;
            font-weight: 600;
        }
        
        .info-note {
            background: #fff8e6;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
            font-size: 14px;
            line-height: 1.5;
        }
        
        /* Booking Summary Details */
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        
        .summary-item {
            display: flex;
            padding-bottom: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .summary-label {
            min-width: 150px;
            color: #666;
            font-weight: 600;
            font-size: 14px;
        }
        
        .summary-value {
            flex: 1;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .highlight {
            color: #022455;
            font-weight: 600;
        }
        
        /* Transparent Pricing */
        .transparency-section {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
        }
        
        .transparency-title {
            color: #2e7d32;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .transparency-title::before {
            content: '✅';
        }
        
        /* Terms & Conditions */
        .terms-section {
            margin: 30px 0;
        }
        
        .terms-title {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .terms-list {
            list-style: none;
            padding: 0;
        }
        
        .terms-list li {
            padding: 8px 0 8px 25px;
            position: relative;
            margin-bottom: 10px;
            color: #5a6c7d;
            line-height: 1.5;
        }
        
        .terms-list li::before {
            content: "•";
            color: #022455;
            font-size: 20px;
            position: absolute;
            left: 0;
            top: 4px;
        }
        
        /* Footer */
        .email-footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .support-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .support-item {
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }
        
        .support-label {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 5px;
        }
        
        .support-value {
            font-size: 16px;
            font-weight: 600;
        }
        
        .support-value a {
            color: #ffffff;
            text-decoration: none;
        }
        
        .company-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .company-name {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        
        .copyright {
            font-size: 12px;
            opacity: 0.7;
            margin-top: 15px;
        }
        
        /* Divider */
        .divider {
            border-top: 2px solid #e9ecef;
            margin: 30px 0;
        }
        
        /* Utility Classes */
        .bold {
            font-weight: 700;
        }
        
        .text-center {
            text-align: center;
        }
        
        .mb-20 {
            margin-bottom: 20px;
        }
        
        .mt-20 {
            margin-top: 20px;
        }
        
        /* Responsive Design */
        @media (max-width: 600px) {
            .email-content {
                padding: 20px;
            }
            
            .summary-label {
                min-width: 120px;
            }
            
            .support-info {
                grid-template-columns: 1fr;
            }
            
            .greeting {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
          
        <!-- Safety Banner -->
        <div class="safety-banner">
            <h1>CAR RENTAL KOLKATA</h1>
            <h5>YOUR SAFETY IS OUR PRIORITY!</h5>
        </div>
        
        <!-- Main Content -->
        <div class="email-content">
            
            <!-- Greeting -->
            <div class="greeting-section">
                <h1 class="greeting">Hi {{ $user->name }},</h1>
                <p class="route-details">
                    Your <span class="route-highlight">{{ $tripType }}</span> booking ID 
                    <span class="route-highlight">{{ $booking->booking_reference }}</span>, 
                    on <span class="route-highlight">{{ $pickupDate }}</span> from 
                    <span class="route-highlight">{{ $fromLocation }}</span> to 
                    <span class="route-highlight">{{ $toLocation }}</span> is confirmed!
                </p>
            </div>
            
            <!-- Important Note -->
            <div class="info-note">
                <strong>📢 Important:</strong> You will receive your driver details within 1 hour of your pick up time. 
                We seek your cooperation to avoid enquiring about the driver details before the specified time. 
                Kindly check the attachment for the complete billing details.
            </div>
            
            <!-- Booking Summary -->
            <div class="booking-summary">
                <div class="booking-id">Booking Summary - {{ $booking->booking_reference }}</div>
                
                <div class="summary-grid">
                    <div class="summary-item">
                        <span class="summary-label">Pickup Time:</span>
                        <span class="summary-value">{{ $pickupTime }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Pickup Location:</span>
                        <span class="summary-value">{{ $booking->pickup_address }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Drop Location:</span>
                        <span class="summary-value">{{ $booking->drop_address }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Trip Details:</span>
                        <span class="summary-value">
                            {{ $fromLocation }} → {{ $toLocation }} 
                            <span class="highlight">({{ $booking->distance_km }} km {{ $tripType }})</span>
                        </span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Car Type:</span>
                        <span class="summary-value">{{ $carType }} or equivalent</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Phone No:</span>
                        <span class="summary-value">******{{ $phoneLastFour ?? 'XXXX' }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Total Amount:</span>
                        <span class="summary-value highlight">₹{{ number_format($totalFare, 2) }} (inclusive of all taxes)</span>
                    </div>
                </div>
            </div>
            
            <!-- Transparency Section -->
            <div class="transparency-section">
                <div class="transparency-title">Complete Transparency in Our Service</div>
                <p style="color: #2e7d32; line-height: 1.6;">
                    We are proud of our promise of complete transparency in our service offerings. 
                    All charges are clearly mentioned in the attached travel itinerary. 
                    No hidden costs, no surprises!
                </p>
            </div>
            
            <!-- Divider -->
            <div class="divider"></div>
            
            <!-- Terms & Conditions -->
            <div class="terms-section">
                <h3 class="terms-title">Please note the important T&C of your trip:</h3>
                <ul class="terms-list">
                    <li>Your Trip has a KM limit. If your usage exceeds this limit, you will be charged for the excess KM used.</li>
                    <li>We promote cleaner fuel and thus your cab can be a CNG vehicle. The driver may need to fill CNG once or more during your trip. Please cooperate with the driver.</li>
                    <li>Your trip includes one pick up in Pick-up city and one drop to destination city. It does not include within city travel.</li>
                    <li>If your Trip has Hill climbs, cab AC may be switched off during such climbs.</li>
                    <li>Toll charges, parking fees, and state taxes are payable directly to the driver during the trip.</li>
                    <li>Driver details will be shared 1 hour before the scheduled pickup time.</li>
                    <li>Free cancellation up to 24 hours before pickup time.</li>
                </ul>
            </div>
            
            <!-- Attachment Note -->
            <div class="info-note" style="background: #e3f2fd; border-color: #90caf9; color: #1565c0;">
                <strong>📎 Attachment:</strong> Your detailed Travel Itinerary is attached to this email. 
                It contains complete billing details, trip summary, and important contact information.
            </div>
            
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <div class="support-info">
                <div class="support-item">
                    <div class="support-label">24x7 Helpline</div>
                    <div class="support-value">
                        <a href="tel:+919073740000">+91 9073740000</a>
                    </div>
                </div>
                
                <div class="support-item">
                    <div class="support-label">Email Support</div>
                    <div class="support-value">
                        <a href="mailto:info.carrentalkolkata@gmail.com">info.carrentalkolkata@gmail.com</a>
                    </div>
                </div>
                
                <div class="support-item">
                    <div class="support-label">Website</div>
                    <div class="support-value">
                        <a href="https://carrentalkolkata.com">carrentalkolkata.com</a>
                    </div>
                </div>
            </div>
            
            <div class="company-footer">
                <div class="company-name">CAR RENTAL KOLKATA</div>
                <div style="font-size: 14px; opacity: 0.9; margin-bottom: 10px;">
                    Premium Cab Services Across India
                </div>
                <div class="copyright">
                    © 2026 Car Rental Kolkata. All rights reserved.<br>
                    This email and any attachments are confidential and intended solely for the use of the individual to whom they are addressed.
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>