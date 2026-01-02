<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Travel Itinerary - Car Rental Kolkata</title>
    <style>
        @page { margin: 20px; }
        
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .tagline {
            font-size: 14px;
            color: #4CAF50;
            font-weight: 500;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .booking-id {
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
            text-align: center;
            margin: 15px 0;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .detail-item {
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        
        .detail-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .detail-value {
            font-size: 13px;
            font-weight: 500;
            color: #333;
        }
        
        .billing-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .billing-table th {
            background: #2c3e50;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: 600;
        }
        
        .billing-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .total-row {
            background: #e8f5e9;
            font-weight: bold;
        }
        
        .terms-list {
            padding-left: 20px;
            margin: 15px 0;
        }
        
        .terms-list li {
            margin-bottom: 8px;
            font-size: 11px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        
        .contact-info {
            margin-top: 10px;
            font-size: 11px;
        }
        
        .highlight {
            color: #4CAF50;
            font-weight: 600;
        }
        
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        
        .qr-placeholder {
            width: 100px;
            height: 100px;
            background: #f0f0f0;
            margin: 0 auto;
            border: 1px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">CAR RENTAL KOLKATA</div>
        <div class="tagline">Travel Itinerary</div>
    </div>
    
    <div class="booking-id">
        Booking ID: {{ $booking['booking_reference'] ?? 'CRK-' . date('ymd') . '-XXXXXX' }}
    </div>
    
    <div class="section">
        <div class="section-title">Booking Details</div>
        
        <div class="details-grid">
            <div class="detail-item">
                <div class="detail-label">Pickup Location</div>
                <div class="detail-value">{{ $booking['pickup_address'] ?? 'Not specified' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Drop Location</div>
                <div class="detail-value">{{ $booking['drop_address'] ?? 'Not specified' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Pickup Time</div>
                <div class="detail-value">{{ $pickupDateTime }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Trip Detail</div>
                <div class="detail-value">
                    @if(isset($booking['from_city']) && is_array($booking['from_city']))
                        {{ $booking['from_city']['name'] ?? 'From City' }}
                    @else
                        {{ $booking['from_location'] ?? 'From City' }}
                    @endif
                    → 
                    @if(isset($booking['to_city']) && is_array($booking['to_city']))
                        {{ $booking['to_city']['name'] ?? 'To City' }}
                    @else
                        {{ $booking['to_location'] ?? 'To City' }}
                    @endif
                    ({{ $booking['distance_km'] ?? 0 }} km {{ $booking['trip_type_display'] ?? 'One-way drop' }})
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Car Type</div>
                <div class="detail-value">
                    @if(isset($booking['cab']) && is_array($booking['cab']))
                        {{ $booking['cab']['cab_name'] ?? 'Standard Car' }}
                    @else
                        {{ $booking['car_type'] ?? 'Standard Car' }}
                    @endif
                    or equivalent
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Customer Name</div>
                <div class="detail-value">{{ $booking['customer_name'] ?? 'Customer' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Customer Email</div>
                <div class="detail-value">{{ $booking['customer_email'] ?? 'N/A' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Customer Mobile</div>
                <div class="detail-value">{{ $booking['customer_mobile'] ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Billing Details</div>
        
        <table class="billing-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Base Fare</td>
                    <td>₹{{ number_format($baseFare, 2) }}</td>
                </tr>
                <tr>
                    <td>GST (5%)</td>
                    <td>₹{{ number_format($gstAmount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Total Amount</strong></td>
                    <td><strong>₹{{ number_format($booking['total_estimated_fare'] ?? 0, 2) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 11px; color: #666; padding-top: 5px;">
                        <em>Inclusive of all taxes. Extra charges if applicable to be paid to driver.</em>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin-top: 15px; font-size: 11px; color: #666;">
            <strong>Payment Method:</strong> 
            @if(($booking['payment_status'] ?? '') === 'paid')
                Paid Online via {{ $booking['payment_mode'] ?? 'Online Payment' }}
            @else
                Pay ₹{{ number_format($booking['total_estimated_fare'] ?? 0, 2) }} to driver during the trip with extras (if applicable)
            @endif
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Extra Charges (if applicable)</div>
        <div style="font-size: 11px; color: #555;">
            <p style="margin: 5px 0;">a) Distance travelled beyond {{ $booking['distance_km'] ?? 0 }} km will be charged at ₹{{ $booking['extra_km_rate'] ?? 17 }}/km.</p>
            <p style="margin: 5px 0;">b) This fare includes inter-state tax and toll, but does not include parking.</p>
            <p style="margin: 5px 0;">c) This fare also includes TDS charges applicable for the trip.</p>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Important Terms & Conditions</div>
        <ul class="terms-list">
            <li>Your Trip has a KM limit. If your usage exceeds this limit, you will be charged for the excess KM used. All extra charges billed over the package price shall include levy of applicable GST.</li>
            <li>We promote cleaner fuel and thus your cab can be a CNG vehicle. The driver may need to fill CNG once or more during your trip. Please cooperate with the driver.</li>
            <li>If you have chosen to pay to driver for your trip amount, please cooperate with driver to pay the amount during the trip.</li>
            <li>Your trip includes one pick up in Pick-up city and one drop to destination city. It does not include within city travel.</li>
            <li>If your Trip has Hill climbs, cab AC may be switched off during such climbs.</li>
            <li>At the end of the trip, please check and take all your belongings with you.</li>
            <li>Any discrepancies regarding bill amount will be considered within 24 hrs of Invoice.</li>
        </ul>
    </div>
    
    <div class="qr-code">
        <div class="qr-placeholder">QR Code<br>(Booking ID: {{ $booking['booking_reference'] ?? 'CRK-XXXX' }})</div>
        <div style="font-size: 10px; color: #666; margin-top: 5px;">Scan for booking details</div>
    </div>
    
    <div class="footer">
        <div class="company-name" style="font-size: 14px;">Car Rental Kolkata</div>
        <div class="contact-info">
            <div>📞 24x7 Helpline: <span class="highlight">{{ $company['phone'] }}</span></div>
            <div>📧 Email: <span class="highlight">{{ $company['email'] }}</span></div>
            <div>🌐 Website: <span class="highlight">{{ $company['website'] }}</span></div>
        </div>
        <div style="margin-top: 15px; font-size: 10px; color: #999;">
            This is a computer-generated document. No signature required.
        </div>
    </div>
</body>
</html>