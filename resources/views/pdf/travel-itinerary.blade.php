<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Travel Itinerary - {{ $booking->booking_reference }}</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #ffffff;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 3px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }
        
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 0px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .subtitle {
            font-size: 12px;
            color: #666;
            font-weight: normal;
        }
        
        /* Section Styles */
        .section {
            margin-bottom: 10px;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            margin-bottom: 7px;
            border-bottom: 2px solid #333;
            padding-bottom: 3px;
        }
        
        /* Details List */
        .details-list {
            list-style: none;
        }
        
        .detail-item {
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
        }
        
        .detail-label {
            min-width: 140px;
            font-weight: bold;
            color: #333;
            flex-shrink: 0;
        }
        
        .detail-value {
            flex: 1;
            color: #000;
        }
        
        .detail-value strong {
            font-weight: bold;
            color: #000;
        }
        
        /* Trip Details */
        .trip-details {
            background: #f5f5f5;
            border-left: 4px solid #333;
            padding: 12px 15px;
            margin: 15px 0;
        }
        
        .trip-route {
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
        }
        
        .trip-distance {
            color: #666;
            font-size: 11px;
        }
        
        /* Billing Section */
        .billing-section {
            margin-top: 10px;
        }
        
        .billing-item {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }
        
        .billing-label {
            font-weight: bold;
            color: #333;
        }
        
        .billing-amount {
            font-weight: bold;
            color: #000;
        }
        
        .total-amount {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #333;
        }
        
        /* Payment Note */
        .payment-note {
            background: #fff8e1;
            border: 1px solid #ffeaa7;
            padding: 10px 15px;
            margin: 15px 0;
            font-size: 11px;
            color: #856404;
        }
        
        /* Extra Charges */
        .extra-charges {
            margin: 20px 0;
        }
        
        .extra-charges-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }
        
        .extra-charges-list {
            padding-left: 20px;
            list-style-type: lower-alpha;
        }
        
        .extra-charges-list li {
            margin-bottom: 6px;
            color: #000;
        }
        
        /* Terms & Conditions */
        .terms-section {
            margin-top: 25px;
        }
        
        .terms-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        .terms-content {
            padding-left: 5px;
        }
        
        .terms-list {
            list-style: none;
            margin-bottom: 15px;
        }
        
        .terms-list li {
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
            line-height: 1.5;
        }
        
        .terms-list li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #000;
            font-size: 16px;
        }
        
        .terms-note {
            margin-top: 15px;
            font-size: 11px;
            color: #666;
        }
        
        /* Footer Links */
        .footer-links {
            margin-top: 25px;
            text-align: center;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
        }
        
        .footer-link {
            font-size: 11px;
            color: #0066cc;
            text-decoration: underline;
        }
        
        /* Utility Classes */
        .bold {
            font-weight: bold;
        }
        
        .text-center {
            text-align: center;
        }
        .mb-5 {
            margin-bottom: 10px;
        }
        .mb-10 {
            margin-bottom: 10px;
        }
        
        .mt-10 {
            margin-top: 10px;
        }
        
        .pt-10 {
            padding-top: 10px;
        }
        
        .border-bottom {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        /* Print Styles */
        @media print {
            body {
                padding: 0;
            }
            
            .container {
                border: none;
                padding: 15px;
            }
            
            .no-print {
                display: none;
            }
        }
        
        /* Monospace for IDs */
        .monospace {
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
        }
        
        /* Highlight Box */
        .highlight-box {
            background: #fff8e1;
            border: 1px solid #ffeaa7;
            padding: 5px 12px;
            margin: 3px 0;
            font-size: 11px;
        }
        
        /* Divider */
        .divider {
            border-top: 1px solid #ccc;
            margin: 7px 0;
        }
        
        /* Indented items */
        .indented {
            margin-left: 20px;
        }
        
        /* List with letters */
        .letter-list {
            list-style-type: lower-alpha;
            padding-left: 20px;
        }
        
        .letter-list li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Header -->
        <div class="header">
            <h1 class="title">Travel Itinerary</h1>
            <div class="subtitle">Booking Confirmation</div>
        </div>
        
        <!-- Booking Details Section -->
        <div class="section">
            <h2 class="section-title">Booking Details:</h2>
            
            <!-- Row 1: Booking ID -->
            <div class="detail-item">
                <span class="detail-label">Booking ID:</span>
                <span class="detail-value monospace">{{ $booking->booking_reference }}</span>
            </div>
            
            <!-- Row 2: Pickup Location -->
            <div class="detail-item">
                <span class="detail-label">Pickup Location:</span>
                <span class="detail-value">
                    {{ $booking->pickup_address }}
                </span>
            </div>
            
            <!-- Row 3: Drop Location -->
            <div class="detail-item">
                <span class="detail-label">Drop Location:</span>
                <span class="detail-value">
                    {{ $booking->drop_address }}
                </span>
            </div>
            
            <!-- Row 4: Pickup Time -->
            <div class="detail-item">
                <span class="detail-label">Pickup Time:</span>
                <span class="detail-value">
                    {{ $pickupTimeFormatted }}, {{ $pickupDateFormatted }}
                </span>
            </div>
            
            <!-- Row 5: Trip Details -->
            <div class="detail-item">
                <span class="detail-label">Trip Details:</span>
                <span class="detail-value">
                    <div class="trip-route">{{ $fromLocation }} – {{ $toLocation }}</div>
                    <div class="trip-distance">{{ $booking->distance_km }} km {{ ucfirst($booking->trip_type) }}</div>
                </span>
            </div>
            
            <!-- Row 6: Car Type -->
            <div class="detail-item">
                <span class="detail-label">Car Type:</span>
                <span class="detail-value">
                    {{ $car['cab_name'] ?? 'Standard Car' }} or equivalent
                </span>
            </div>
        </div>
        
        <!-- Divider -->
        <div class="divider"></div>
        
        <!-- Billing Details Section -->
        <div class="section billing-section">
            <h2 class="section-title">Billing Details:</h2>
            
            <!-- Total Amount -->
            <div class="billing-item">
                <span class="billing-label">Total Amount:</span>
                <span class="billing-amount">
                    Rs. {{ number_format($booking->total_estimated_fare, 2) }} (inclusive of taxes)
                </span>
            </div>
            
            <!-- Breakup -->
            <div class="indented">
                <div class="billing-item">
                    <span class="billing-label">a) Basic Fare:</span>
                    <span class="billing-amount">
                        Rs. {{ number_format($booking->fare_without_gst, 2) }}
                    </span>
                </div>
                
                <div class="billing-item">
                    <span class="billing-label">b) GST (5%):</span>
                    <span class="billing-amount">
                        Rs. {{ number_format($gstAmount, 2) }}
                    </span>
                </div>
            </div>
            
            <!-- Payment Method -->
            <div class="payment-note">
                <strong>Payment Method:</strong><br>
                @if($booking->payment_status == 'paid')
                    Paid online (Transaction ID: {{ $booking->payment_id }})
                @else
                    Pay Rs. {{ number_format($booking->total_estimated_fare, 2) }} to driver during the trip with entries if applicable
                @endif
            </div>
        </div>
        
        <!-- Divider -->
        <div class="divider"></div>
        
        <!-- Extra Charges Section -->
        <div class="section extra-charges">
            <h3 class="extra-charges-title">
                Extra Charges, if applicable (to be paid to the driver during the trip):
            </h3>
            
            <ol class="letter-list">
                <li>
                    Distance travelled beyond {{ $booking->distance_km }} km will be charged at Rs. {{ $extraChargePerKm }}/km.
                </li>
                <li>
                    This fare includes inter-state tax and toll, but does not include parking.
                </li>
                <li>
                    This fare also includes TCS charges applicable for the trip.
                </li>
            </ol>
        </div>
        
        <!-- Divider -->
        <div class="divider"></div>
        
        <!-- Terms & Conditions -->
        <div class="section terms-section">
            <h3 class="terms-title">Important T&C:</h3>
            
            <div class="terms-content">
                <ul class="terms-list">
                    <li>
                        Your Trip has a KM limit. If your usage exceeds this limit, you will be charged for the extra KM used. All extra charges shall apply for passenger car and in multi-way as applicable (GST to be charged extra).
                    </li>
                    <li>
                        The driver shall know the route. We request you to cooperate with the driver when he takes this call as well as at rest stops etc.
                    </li>
                    <li>
                        We promote cleaner fuel and thus your cab can be a CNG vehicle. The driver may need to fill CNG once or twice during your trip, please cooperate with the driver.
                    </li>
                    <li>
                        If you have chosen to pay by driver for your trip amount, please cooperate with driver to pay the remaining amount in advance in the day.
                    </li>
                    <li>
                        If the vehicle breaks down on the way due to any reason, a new vehicle shall be arranged within 2 hours. If the vehicle is not arranged within 3 hours, we shall refund the proportionate amount of your trip (till that point of journey).
                    </li>
                    <li>
                        If you are on hill station route, extra hill charges shall apply.
                    </li>
                    <li>
                        Any discrepancies regarding bill amount will be considered within 24 hours of invoice.
                    </li>
                </ul>
                
                <div class="terms-note">
                    For complete terms & conditions, cancellation policy and other details, please refer to the main terms document.
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer-links">
            <div class="highlight-box">
                <strong>Note:</strong> Please keep this itinerary with you during the trip. Driver details will be shared 1 hour before pickup.
            </div>
            
            <div class="mb-5">
                <strong>24x7 Support:</strong> +91 90 7374 0000 | info.carrentalkolkata@gmail.com
            </div>
            
            <div>
                <span class="footer-link">Detailed T&C</span> | 
                <span class="footer-link">Cancellation Policy</span> | 
                <span class="footer-link">Privacy Policy</span>
            </div>
            
            <div style="margin-top: 5px; font-size: 10px; color: #666;">
                Generated on: {{ now()->format('d M Y, h:i A') }} | 
                Document ID: {{ $booking->booking_reference }}-ITINERARY
            </div>
        </div>
        
    </div>
</body>
</html>