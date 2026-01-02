<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $booking->booking_reference }}</title>
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background: #ffffff;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        
        /* Header Section */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 3px solid #f44336;
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: 800;
            color: #f44336;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .company-tagline {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .company-details {
            color: #555;
            line-height: 1.8;
        }
        
        .invoice-title {
            text-align: right;
        }
        
        .invoice-title h1 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .invoice-number {
            font-size: 18px;
            color: #666;
            font-weight: 600;
        }
        
        .invoice-status {
            display: inline-block;
            padding: 8px 20px;
            background: #4CAF50;
            color: white;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 10px;
        }
        
        /* Customer & Booking Info */
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 40px;
        }
        
        .info-box {
            flex: 1;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .info-box h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f2f5;
            font-size: 18px;
            font-weight: 700;
        }
        
        .info-item {
            display: flex;
            margin-bottom: 12px;
        }
        
        .info-label {
            min-width: 140px;
            color: #666;
            font-weight: 500;
        }
        
        .info-value {
            color: #333;
            font-weight: 600;
        }
        
        /* Trip Details */
        .trip-details {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 30px;
            color: white;
            margin-bottom: 40px;
        }
        
        .trip-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .trip-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .trip-item {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }
        
        .trip-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .trip-value {
            font-size: 18px;
            font-weight: 700;
        }
        
        /* Fare Breakdown */
        .fare-section {
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .fare-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .fare-table thead {
            background: linear-gradient(135deg, #f44336 0%, #ff6b6b 100%);
            color: white;
        }
        
        .fare-table th {
            padding: 20px;
            text-align: left;
            font-weight: 600;
            font-size: 15px;
        }
        
        .fare-table tbody tr {
            border-bottom: 1px solid #f0f2f5;
        }
        
        .fare-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .fare-table td {
            padding: 20px;
            color: #333;
        }
        
        .fare-table tfoot {
            background: #2c3e50;
            color: white;
        }
        
        .fare-table tfoot td {
            padding: 25px 20px;
            font-size: 18px;
            font-weight: 700;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-left {
            text-align: left;
        }
        
        .text-center {
            text-align: center;
        }
        
        /* Terms & Conditions */
        .terms-section {
            background: #fff8e6;
            border: 2px solid #ffeaa7;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 40px;
        }
        
        .terms-title {
            color: #856404;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .terms-list {
            list-style: none;
            padding: 0;
        }
        
        .terms-list li {
            padding: 8px 0 8px 30px;
            color: #856404;
            position: relative;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        
        .terms-list li::before {
            content: "•";
            color: #f44336;
            font-size: 20px;
            position: absolute;
            left: 0;
            top: 4px;
        }
        
        /* Payment Instructions */
        .payment-section {
            background: #e8f5e9;
            border: 2px solid #a5d6a7;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 40px;
        }
        
        .payment-title {
            color: #2e7d32;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .payment-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .payment-item {
            padding: 15px;
            background: rgba(255,255,255,0.5);
            border-radius: 8px;
        }
        
        .payment-label {
            color: #2e7d32;
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .payment-value {
            color: #333;
            font-weight: 500;
        }
        
        /* Footer */
        .invoice-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 40px;
            border-top: 2px solid #f0f2f5;
            margin-top: 40px;
        }
        
        .footer-left {
            color: #666;
            font-size: 14px;
        }
        
        .footer-right {
            text-align: right;
        }
        
        .authorized-sign {
            margin-top: 30px;
            border-top: 1px solid #333;
            padding-top: 10px;
            display: inline-block;
        }
        
        .stamp {
            background: #f44336;
            color: white;
            padding: 15px 30px;
            border-radius: 5px;
            font-weight: 700;
            font-size: 16px;
            transform: rotate(5deg);
        }
        
        /* QR Code Section */
        .qr-section {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 12px;
            margin: 40px 0;
        }
        
        .qr-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .qr-code {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }
        
        /* Utility Classes */
        .mb-20 {
            margin-bottom: 20px;
        }
        
        .mb-30 {
            margin-bottom: 30px;
        }
        
        .mt-20 {
            margin-top: 20px;
        }
        
        .mt-30 {
            margin-top: 30px;
        }
        
        /* Page Break for PDF */
        @media print {
            .invoice-container {
                padding: 20px;
            }
            
            .page-break {
                page-break-before: always;
            }
        }
        
        /* Bank Details */
        .bank-details {
            background: #e3f2fd;
            border: 2px solid #90caf9;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
        }
        
        .bank-title {
            color: #1565c0;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .bank-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .bank-item {
            padding: 12px;
            background: rgba(255,255,255,0.7);
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1 class="company-name">CAR RENTAL KOLKATA</h1>
                <p class="company-tagline">Premium Cab Services Across India</p>
                <div class="company-details">
                    <div><strong>Address:</strong> Kolkata, West Bengal, India</div>
                    <div><strong>Phone:</strong> +91 90 7374 0000</div>
                    <div><strong>Email:</strong> info.carrentalkolkata@gmail.com</div>
                    <div><strong>Website:</strong> www.carrentalkolkata.com</div>
                    <div><strong>GSTIN:</strong> 19AABCC1234M1Z5</div>
                </div>
            </div>
            
            <div class="invoice-title">
                <h1>TAX INVOICE</h1>
                <div class="invoice-number">
                    Invoice #: {{ $invoiceNumber ?? 'INV-' . $booking->booking_reference }}
                </div>
                <div class="invoice-status">
                    @if($booking->payment_status == 'paid')
                        PAID
                    @else
                        PENDING PAYMENT
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Invoice Details -->
        <div class="info-section">
            <div class="info-box">
                <h3>Invoice Details</h3>
                <div class="info-item">
                    <span class="info-label">Invoice Date:</span>
                    <span class="info-value">{{ $invoiceDate ?? now()->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Invoice Number:</span>
                    <span class="info-value">{{ $invoiceNumber ?? 'INV-' . $booking->booking_reference }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Booking ID:</span>
                    <span class="info-value">{{ $booking->booking_reference }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment ID:</span>
                    <span class="info-value">{{ $booking->payment_id ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment Status:</span>
                    <span class="info-value" style="color: {{ $booking->payment_status == 'paid' ? '#4CAF50' : '#FF9800' }}; font-weight: 700;">
                        {{ strtoupper($booking->payment_status) }}
                    </span>
                </div>
            </div>
            
            <div class="info-box">
                <h3>Customer Details</h3>
                <div class="info-item">
                    <span class="info-label">Customer Name:</span>
                    <span class="info-value">{{ $user->name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">{{ $user->phone ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $user->email ?? 'N/A' }}</span>
                </div>
                @if($booking->company_name)
                <div class="info-item">
                    <span class="info-label">Company Name:</span>
                    <span class="info-value">{{ $booking->company_name }}</span>
                </div>
                @endif
                @if($booking->gst_number)
                <div class="info-item">
                    <span class="info-label">GST Number:</span>
                    <span class="info-value">{{ $booking->gst_number }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Trip Details -->
        <div class="trip-details">
            <h3 class="trip-title">
                <span>🚗</span> Trip Details
            </h3>
            <div class="trip-grid">
                <div class="trip-item">
                    <div class="trip-label">
                        <span>📍</span> Pickup From
                    </div>
                    <div class="trip-value">{{ $booking->pickup_address }}</div>
                </div>
                <div class="trip-item">
                    <div class="trip-label">
                        <span>🏁</span> Drop To
                    </div>
                    <div class="trip-value">{{ $booking->drop_address }}</div>
                </div>
                <div class="trip-item">
                    <div class="trip-label">
                        <span>📅</span> Pickup Date
                    </div>
                    <div class="trip-value">{{ date('d M Y', strtotime($booking->pickup_date)) }}</div>
                </div>
                <div class="trip-item">
                    <div class="trip-label">
                        <span>⏰</span> Pickup Time
                    </div>
                    <div class="trip-value">{{ date('h:i A', strtotime($booking->pickup_time)) }}</div>
                </div>
                <div class="trip-item">
                    <div class="trip-label">
                        <span>🛣️</span> Distance
                    </div>
                    <div class="trip-value">{{ $booking->distance_km }} KM</div>
                </div>
                <div class="trip-item">
                    <div class="trip-label">
                        <span>🎫</span> Trip Type
                    </div>
                    <div class="trip-value">{{ ucfirst($booking->trip_type) }}</div>
                </div>
            </div>
        </div>
        
        <!-- Fare Breakdown -->
        <div class="fare-section">
            <h3 class="section-title">
                <span>💰</span> Fare Breakdown
            </h3>
            <table class="fare-table">
                <thead>
                    <tr>
                        <th class="text-left">Description</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Rate (₹)</th>
                        <th class="text-center">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $booking->trip_type == 'hourly' ? 'Hourly Rental' : 'Distance Fare' }}</strong><br>
                            <small>{{ $booking->distance_km }} {{ $booking->trip_type == 'hourly' ? 'hours' : 'km' }} @ ₹{{ round($booking->fare_without_gst / max($booking->distance_km, 1), 2) }}/{{ $booking->trip_type == 'hourly' ? 'hour' : 'km' }}</small>
                        </td>
                        <td class="text-center">{{ $booking->distance_km }}</td>
                        <td class="text-center">₹{{ round($booking->fare_without_gst / max($booking->distance_km, 1), 2) }}</td>
                        <td class="text-center">₹{{ number_format($booking->fare_without_gst, 2) }}</td>
                    </tr>
                    
                    <!-- Additional Services -->
                    <tr>
                        <td>
                            <strong>Driver Allowance</strong><br>
                            <small>Includes driver charges and food allowance</small>
                        </td>
                        <td class="text-center">1</td>
                        <td class="text-center">₹{{ round(($booking->total_estimated_fare - $booking->fare_without_gst) / 2, 2) }}</td>
                        <td class="text-center">₹{{ round(($booking->total_estimated_fare - $booking->fare_without_gst) / 2, 2) }}</td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>Service Tax & Charges</strong><br>
                            <small>GST @ 5% and other applicable charges</small>
                        </td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">₹{{ round(($booking->total_estimated_fare - $booking->fare_without_gst) / 2, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">
                            <strong>TOTAL AMOUNT</strong>
                        </td>
                        <td class="text-center">
                            <strong>₹{{ number_format($booking->total_estimated_fare, 2) }}</strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Payment Instructions -->
        <div class="payment-section">
            <h3 class="payment-title">
                <span>💳</span> Payment Information
            </h3>
            <div class="payment-info">
                <div class="payment-item">
                    <div class="payment-label">
                        <span>💰</span> Total Amount
                    </div>
                    <div class="payment-value">₹{{ number_format($booking->total_estimated_fare, 2) }}</div>
                </div>
                <div class="payment-item">
                    <div class="payment-label">
                        <span>📊</span> Base Fare
                    </div>
                    <div class="payment-value">₹{{ number_format($booking->fare_without_gst, 2) }}</div>
                </div>
                <div class="payment-item">
                    <div class="payment-label">
                        <span>📈</span> Taxes & Charges
                    </div>
                    <div class="payment-value">₹{{ number_format($booking->total_estimated_fare - $booking->fare_without_gst, 2) }}</div>
                </div>
                <div class="payment-item">
                    <div class="payment-label">
                        <span>✅</span> Payment Status
                    </div>
                    <div class="payment-value" style="color: {{ $booking->payment_status == 'paid' ? '#4CAF50' : '#FF9800' }}; font-weight: 700;">
                        {{ strtoupper($booking->payment_status) }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bank Details -->
        <div class="bank-details">
            <h3 class="bank-title">
                <span>🏦</span> Bank Details
            </h3>
            <div class="bank-grid">
                <div class="bank-item">
                    <div><strong>Account Name:</strong> Car Rental Kolkata</div>
                </div>
                <div class="bank-item">
                    <div><strong>Account Number:</strong> 1234567890123</div>
                </div>
                <div class="bank-item">
                    <div><strong>Bank Name:</strong> State Bank of India</div>
                </div>
                <div class="bank-item">
                    <div><strong>IFSC Code:</strong> SBIN0001234</div>
                </div>
                <div class="bank-item">
                    <div><strong>Branch:</strong> Kolkata Main Branch</div>
                </div>
                <div class="bank-item">
                    <div><strong>UPI ID:</strong> carrentalkolkata@upi</div>
                </div>
            </div>
        </div>
        
        <!-- Terms & Conditions -->
        <div class="terms-section">
            <h3 class="terms-title">
                <span>📋</span> Terms & Conditions
            </h3>
            <ul class="terms-list">
                <li>This invoice is valid for payment within 7 days from the date of issue</li>
                <li>Trip includes a KM limit. Additional charges apply for extra kilometers</li>
                <li>Toll charges, parking fees, and state taxes are payable directly to driver</li>
                <li>Cancellation policy: Free cancellation up to 24 hours before pickup</li>
                <li>Driver details will be shared 1 hour before scheduled pickup time</li>
                <li>Late payments may attract interest @ 1.5% per month</li>
                <li>All disputes subject to Kolkata jurisdiction only</li>
            </ul>
        </div>
        
        <!-- QR Code Section -->
        <div class="qr-section">
            <h3 class="qr-title">Quick Payment via QR Code</h3>
            <div class="qr-code">
                <!-- Placeholder for QR Code -->
                <div style="text-align: center; color: #666;">
                    <div style="font-size: 24px;">🔳</div>
                    <div style="font-size: 12px; margin-top: 5px;">QR Code</div>
                </div>
            </div>
            <p style="color: #666;">Scan to pay using UPI apps</p>
        </div>
        
        <!-- Footer -->
        <div class="invoice-footer">
            <div class="footer-left">
                <div style="margin-bottom: 10px;">
                    <strong>For any queries regarding this invoice, please contact:</strong>
                </div>
                <div>📞 +91 90 7374 0000 | 📧 info.carrentalkolkata@gmail.com</div>
                <div>Thank you for choosing Car Rental Kolkata!</div>
            </div>
            
            <div class="footer-right">
                <div class="authorized-sign">
                    <div>Authorized Signature</div>
                </div>
                <div class="stamp mt-20">
                    PAID
                </div>
            </div>
        </div>
        
        <!-- Page 2: Additional Information (Optional) -->
        <div class="page-break mt-40">
            <div class="terms-section">
                <h3 class="terms-title">
                    <span>📜</span> Additional Terms & Policies
                </h3>
                <ul class="terms-list">
                    <li><strong>Cancellation Policy:</strong> 100% refund if cancelled 24 hours before pickup. 50% refund if cancelled 12-24 hours before. No refund within 12 hours.</li>
                    <li><strong>Vehicle Condition:</strong> All vehicles are fully insured and maintained as per manufacturer standards.</li>
                    <li><strong>Driver Expertise:</strong> All drivers are experienced, licensed, and background verified.</li>
                    <li><strong>Breakdown Support:</strong> 24x7 roadside assistance available throughout the trip.</li>
                    <li><strong>Extra Charges:</strong> Night charges (10 PM to 6 AM) - 25% extra. Hill station charges - 15% extra.</li>
                    <li><strong>Waiting Charges:</strong> Free waiting time: 30 minutes at airport/railway station, 15 minutes at other locations.</li>
                    <li><strong>Luggage:</strong> Standard luggage capacity as per vehicle type. Extra luggage may require different vehicle.</li>
                    <li><strong>Route Changes:</strong> Any route changes during the trip must be approved by the driver.</li>
                    <li><strong>ID Proof:</strong> Customer must carry valid ID proof during the trip.</li>
                    <li><strong>Smoking/Alcohol:</strong> Strictly prohibited inside the vehicle.</li>
                </ul>
            </div>
            
            <div class="payment-section mt-30">
                <h3 class="payment-title">
                    <span>⚠️</span> Important Notes
                </h3>
                <ul class="terms-list">
                    <li>Please verify all details mentioned in this invoice before payment</li>
                    <li>Keep this invoice for your records and future references</li>
                    <li>Booking confirmation is subject to vehicle availability</li>
                    <li>Company reserves the right to provide equivalent or better vehicle in case of non-availability</li>
                    <li>Fares are subject to change without prior notice for bookings made well in advance</li>
                    <li>In case of any discrepancy, please contact within 24 hours of receiving this invoice</li>
                </ul>
            </div>
        </div>
        
    </div>
</body>
</html>