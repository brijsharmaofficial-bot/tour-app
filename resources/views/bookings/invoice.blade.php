@extends('layouts.app')
@section('title', 'Invoice #'.$booking->id)

@section('content')
<div class="container py-4" id="invoiceArea">
    <div class="card shadow-lg border-0">
        <div class="card-body p-5">

            <!-- ===================== HEADER ===================== -->
            <div class="row border-bottom pb-4 mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        @if($company->logo ?? false)
                        <img src="{{ asset($company->logo) }}" alt="{{ $company->company_name }}" class="me-3" style="height: 60px;">
                        @else
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-car fs-4"></i>
                        </div>
                        @endif
                        <div>
                            <h2 class="fw-bold text-primary mb-1">{{ $company->company_name ?? 'INFRENIX TOURS' }}</h2>
                            <p class="mb-0 text-muted">{{ $company->tagline ?? 'Your Reliable Travel Partner' }}</p>
                            <small class="text-muted">
                                {{ $company->email ?? 'support@infrenix.com' }} | 
                                {{ $company->phone ?? '+91 00000 00000' }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="bg-light p-3 rounded d-inline-block">
                        <h1 class="text-uppercase fw-bold text-primary mb-1">INVOICE</h1>
                        <p class="mb-0 text-muted">#INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <small class="text-muted">Issued: {{ $booking->created_at->format('d M, Y') }}</small>
                    </div>
                </div>
            </div>

            <!-- ===================== COMPANY + CLIENT INFO ===================== -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-secondary mb-3">FROM:</h6>
                            <p class="mb-1 fw-semibold">{{ $company->company_name ?? 'Infrenix Tours' }}</p>
                            <p class="mb-1 text-muted small">{{ $company->corporate_office ?? 'Corporate Office Address' }}</p>
                            <p class="mb-1 text-muted small">
                                <strong>GST:</strong> {{ $company->gst_number ?? 'GSTINXXXXXXX' }}
                            </p>
                            <p class="mb-0 text-muted small">
                                <strong>PAN:</strong> {{ $company->pan_number ?? 'PANXXXXXXX' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-secondary mb-3">BILL TO:</h6>
                            <div class="mb-2">
                                <label class="form-label small text-muted mb-1">Customer Name</label>
                                <input type="text" name="user_name" class="form-control form-control-sm" value="{{ $booking->user->name ?? 'Guest User' }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small text-muted mb-1">Email</label>
                                <input type="text" name="user_email" class="form-control form-control-sm" value="{{ $booking->user->email ?? '' }}">
                            </div>
                            <div>
                                <label class="form-label small text-muted mb-1">Phone</label>
                                <input type="text" name="user_phone" class="form-control form-control-sm" value="{{ $booking->user->phone ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== TRIP INFORMATION ===================== -->
            <div class="card border-0 bg-primary bg-opacity-10 mb-4">
                <div class="card-body">
                    <h6 class="fw-bold text-primary mb-3">TRIP INFORMATION</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label small text-muted mb-1">Pickup Location</label>
                            <textarea name="pickup_address" class="form-control" rows="2">{{ $booking->pickup_address }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small text-muted mb-1">Drop Location</label>
                            <textarea name="drop_address" class="form-control" rows="2">{{ $booking->drop_address ?? 'Not specified' }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small text-muted mb-1">Route</label>
                            <div class="d-flex align-items-center">
                                <input type="text" name="from_city" class="form-control form-control-sm me-2" value="{{ $booking->fromCity->name ?? '' }}">
                                <i class="fas fa-arrow-right text-muted mx-1"></i>
                                <input type="text" name="to_city" class="form-control form-control-sm ms-2" value="{{ $booking->toCity->name ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label small text-muted mb-1">Pickup Date</label>
                            <input type="date" name="pickup_date" class="form-control form-control-sm" value="{{ $booking->pickup_date }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label small text-muted mb-1">Pickup Time</label>
                            <input type="time" name="pickup_time" class="form-control form-control-sm" value="{{ $booking->pickup_time }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label small text-muted mb-1">Distance (km)</label>
                            <input type="number" id="distance_km" class="form-control form-control-sm text-end" value="{{ $booking->distance_km ?? 0 }}" step="0.1">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label small text-muted mb-1">Duration</label>
                            <input type="text" name="duration" class="form-control form-control-sm" value="{{ $booking->estimated_duration ?? 'N/A' }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== SERVICE DETAILS ===================== -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center" style="width: 5%">#</th>
                            <th style="width: 25%">Service Description</th>
                            <th class="text-center" style="width: 15%">Vehicle Type</th>
                            <th class="text-center" style="width: 10%">Distance (km)</th>
                            <th class="text-center" style="width: 15%">Rate (₹/km)</th>
                            <th class="text-center" style="width: 15%">Base Fare (₹)</th>
                            <th class="text-end" style="width: 15%">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Base Fare Row -->
                        <tr>
                            <td class="text-center fw-bold">1</td>
                            <td>
                                <div class="mb-1">
                                    <input type="text" name="cab_name" class="form-control form-control-sm" value="{{ $booking->cab->cab_name ?? 'Not Assigned' }}">
                                </div>
                                <small class="text-muted">
                                    Trip Type: 
                                    <input type="text" name="trip_type" class="form-control form-control-sm d-inline-block w-auto" value="{{ ucfirst($booking->package->tripType->name ?? 'One Way') }}">
                                </small>
                            </td>
                            <td class="text-center">
                                <input type="text" name="vehicle_type" class="form-control form-control-sm text-center" value="{{ $booking->package->vehicleType->name ?? 'Standard' }}">
                            </td>
                            <td class="text-center">
                                <input type="number" id="distance_km_input" class="form-control form-control-sm text-center" value="{{ $booking->distance_km ?? 0 }}" step="0.1">
                            </td>
                            <td class="text-center">
                                <input type="number" id="rate_per_km" class="form-control form-control-sm text-center" value="{{ $booking->package->price_per_km ?? 15 }}" step="0.01">
                            </td>
                            <td class="text-center">
                                <input type="number" id="base_fare" class="form-control form-control-sm text-center" value="{{ $booking->package->base_fare ?? 50 }}" step="0.01">
                            </td>
                            <td class="text-end fw-semibold">
                                ₹<span id="subtotal_display">
                                    {{ number_format((($booking->distance_km ?? 0) * ($booking->package->price_per_km ?? 15)) + ($booking->package->base_fare ?? 50), 2) }}
                                </span>
                            </td>
                        </tr>
                        
                        <!-- Additional Charges -->
                        <tr>
                            <td class="text-center fw-bold">2</td>
                            <td colspan="4">
                                <input type="text" class="form-control form-control-sm" value="Additional Charges (Toll, Parking, etc.)">
                            </td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-end">
                                ₹<input type="number" id="additional_charges" class="form-control form-control-sm d-inline-block w-75 text-end" value="{{ $booking->toll_charges + $booking->parking_charges ?? 0 }}" step="0.01">
                            </td>
                        </tr>
                        
                        <!-- Waiting Charges -->
                        <tr>
                            <td class="text-center fw-bold">3</td>
                            <td colspan="4">
                                <div class="d-flex align-items-center">
                                    <span>Waiting Charges</span>
                                    <input type="number" id="waiting_minutes" class="form-control form-control-sm d-inline-block w-25 mx-2 text-center" value="{{ $booking->waiting_minutes ?? 0 }}" min="0">
                                    <span>minutes @ ₹</span>
                                    <input type="number" id="waiting_rate" class="form-control form-control-sm d-inline-block w-25 mx-2 text-center" value="{{ $booking->package->waiting_charges ?? 2 }}" step="0.01">
                                    <span>/min</span>
                                </div>
                            </td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-end">
                                ₹<span id="waiting_charges_display">{{ number_format(($booking->waiting_minutes ?? 0) * ($booking->package->waiting_charges ?? 2), 2) }}</span>
                            </td>
                        </tr>
                        
                        <!-- Night Charges -->
                        <tr>
                            <td class="text-center fw-bold">4</td>
                            <td colspan="4">
                                <input type="text" class="form-control form-control-sm" value="Night Charges (10 PM - 6 AM)">
                            </td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-end">
                                ₹<input type="number" id="night_charges" class="form-control form-control-sm d-inline-block w-75 text-end" value="{{ $booking->night_charges ?? 0 }}" step="0.01">
                            </td>
                        </tr>

                        <!-- Extra KM Charges -->
                        <tr>
                            <td class="text-center fw-bold">5</td>
                            <td colspan="4">
                                <div class="d-flex align-items-center">
                                    <span>Extra KM Charges</span>
                                    <input type="number" id="extra_km" class="form-control form-control-sm d-inline-block w-25 mx-2 text-center" value="{{ $booking->extra_km ?? 0 }}" min="0" step="0.1">
                                    <span>km @ ₹</span>
                                    <input type="number" id="extra_km_rate" class="form-control form-control-sm d-inline-block w-25 mx-2 text-center" value="{{ $booking->extra_km_rate ?? 16 }}" step="0.01">
                                    <span>/km</span>
                                </div>
                            </td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-end fw-semibold">
                                ₹<span id="extra_km_charges_display">{{ number_format(($booking->extra_km ?? 0) * ($booking->extra_km_rate ?? 16), 2) }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ===================== TOTALS ===================== -->
            @php
                $distance_fare = ($booking->distance_km ?? 0) * ($booking->package->price_per_km ?? 15);
                $base_fare = $booking->package->base_fare ?? 50;
                $subtotal = $distance_fare + $base_fare;
                $additional_charges = $booking->toll_charges + $booking->parking_charges ?? 0;
                $waiting_charges = ($booking->waiting_minutes ?? 0) * ($booking->package->waiting_charges ?? 2);
                $night_charges = $booking->night_charges ?? 0;
                $extra_km_charges = ($booking->extra_km ?? 0) * ($booking->extra_km_rate ?? 16);
                
                $total_before_tax = $subtotal + $additional_charges + $waiting_charges + $night_charges + $extra_km_charges;
                $gst = $total_before_tax * (($booking->package->gst ?? 5) / 100);
                $round_off = 0;
                $grand_total = $total_before_tax + $gst;
            @endphp

            <div class="row justify-content-end">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-muted">Subtotal:</td>
                            <td class="text-end fw-semibold">₹<span id="subtotal_val">{{ number_format($subtotal, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Additional Charges:</td>
                            <td class="text-end fw-semibold">₹<span id="additional_charges_display">{{ number_format($additional_charges, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Waiting Charges:</td>
                            <td class="text-end fw-semibold">₹<span id="waiting_charges_total">{{ number_format($waiting_charges, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Night Charges:</td>
                            <td class="text-end fw-semibold">₹<span id="night_charges_display">{{ number_format($night_charges, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Extra KM Charges:</td>
                            <td class="text-end fw-semibold">₹<span id="extra_km_charges_total">{{ number_format($extra_km_charges, 2) }}</span></td>
                        </tr>
                        <tr class="table-light">
                            <td class="fw-bold">Total Before Tax:</td>
                            <td class="text-end fw-bold">₹<span id="total_before_tax">{{ number_format($total_before_tax, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">
                                GST @ 
                                <input type="number" id="gst_rate" class="form-control form-control-sm d-inline-block w-25 text-end" value="{{ $booking->package->gst ?? 5 }}" step="0.01">%
                            </td>
                            <td class="text-end fw-semibold">₹<span id="gst_val">{{ number_format($gst, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Round Off:</td>
                            <td class="text-end fw-semibold">₹<span id="round_off">0.00</span></td>
                        </tr>
                        <tr class="table-primary">
                            <td class="fw-bold fs-5">Grand Total:</td>
                            <td class="text-end fw-bold fs-5 text-primary">₹<span id="total_val">{{ number_format($grand_total, 2) }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- ===================== PAYMENT INFORMATION ===================== -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-secondary mb-3">PAYMENT INFORMATION</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1 small"><strong>Payment Status:</strong></p>
                                    <span class="badge bg-{{ $booking->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1 small"><strong>Payment Method:</strong></p>
                                    <span class="text-capitalize">{{ $booking->payment_method ?? 'Cash' }}</span>
                                </div>
                            </div>
                            @if($booking->payment_status == 'paid' && $booking->paid_at)
                            <p class="mb-0 small mt-2">
                                <strong>Paid On:</strong> {{ $booking->paid_at->format('d M, Y h:i A') }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-secondary mb-3">BANK DETAILS</h6>
                            <p class="mb-1 small"><strong>Bank:</strong> {{ $company->bank_name ?? 'State Bank of India' }}</p>
                            <p class="mb-1 small"><strong>Account Name:</strong> {{ $company->company_name ?? 'Infrenix Tours' }}</p>
                            <p class="mb-1 small"><strong>A/C No:</strong> {{ $company->bank_account ?? 'XXXXXXX' }}</p>
                            <p class="mb-0 small"><strong>IFSC:</strong> {{ $company->ifsc_code ?? 'SBIN0000000' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== TERMS & CONDITIONS ===================== -->
            <div class="border-top pt-4 mt-4">
                <h6 class="fw-bold text-secondary mb-2">TERMS & CONDITIONS</h6>
                <ul class="small text-muted mb-0">
                    <li>Payment is due within 15 days of invoice date</li>
                    <li>Late payments are subject to 1.5% monthly interest charge</li>
                    <li>Extra KM charges: ₹<span id="terms_extra_rate">{{ $booking->extra_km_rate ?? 16 }}</span>/km</li>
                    <li>This is a computer generated invoice</li>
                </ul>
            </div>

            <!-- ===================== FOOTER ===================== -->
            <div class="d-flex justify-content-between align-items-center mt-5 border-top pt-3">
                <div>
                    <p class="text-muted mb-0 small">
                        <strong>Authorized Signatory</strong>
                    </p>
                    <p class="text-muted mb-0 small">{{ $company->company_name ?? 'Infrenix Tours' }}</p>
                </div>
                <div class="text-end">
                    <p class="text-muted mb-2 small">Thank you for your business!</p>
                    <div class="btn-group">
                        <button class="btn btn-primary btn-sm" onclick="downloadPDF()">
                            <i class="fas fa-download me-1"></i> Download PDF
                        </button>
                        <button class="btn btn-success btn-sm" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> Print Invoice
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="sendEmail()">
                            <i class="fas fa-envelope me-1"></i> Email Invoice
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const elements = {
        distance: document.getElementById('distance_km_input'),
        rate: document.getElementById('rate_per_km'),
        baseFare: document.getElementById('base_fare'),
        additionalCharges: document.getElementById('additional_charges'),
        waitingMinutes: document.getElementById('waiting_minutes'),
        waitingRate: document.getElementById('waiting_rate'),
        nightCharges: document.getElementById('night_charges'),
        extraKm: document.getElementById('extra_km'),
        extraKmRate: document.getElementById('extra_km_rate'),
        gstRate: document.getElementById('gst_rate')
    };

    const displays = {
        subtotal: document.getElementById('subtotal_display'),
        subtotalVal: document.getElementById('subtotal_val'),
        additionalCharges: document.getElementById('additional_charges_display'),
        waitingCharges: document.getElementById('waiting_charges_display'),
        waitingChargesTotal: document.getElementById('waiting_charges_total'),
        nightCharges: document.getElementById('night_charges_display'),
        extraKmCharges: document.getElementById('extra_km_charges_display'),
        extraKmChargesTotal: document.getElementById('extra_km_charges_total'),
        totalBeforeTax: document.getElementById('total_before_tax'),
        gst: document.getElementById('gst_val'),
        roundOff: document.getElementById('round_off'),
        total: document.getElementById('total_val'),
        termsExtraRate: document.getElementById('terms_extra_rate')
    };

    function recalc() {
        // Calculate basic fare
        const km = parseFloat(elements.distance.value) || 0;
        const rate = parseFloat(elements.rate.value) || 0;
        const base = parseFloat(elements.baseFare.value) || 0;
        const distanceFare = km * rate;
        const subtotal = distanceFare + base;

        // Additional charges
        const additional = parseFloat(elements.additionalCharges.value) || 0;
        const waitingMins = parseFloat(elements.waitingMinutes.value) || 0;
        const waitingRate = parseFloat(elements.waitingRate.value) || 0;
        const waitingCharges = waitingMins * waitingRate;
        const night = parseFloat(elements.nightCharges.value) || 0;
        
        // Extra KM charges
        const extraKm = parseFloat(elements.extraKm.value) || 0;
        const extraKmRate = parseFloat(elements.extraKmRate.value) || 0;
        const extraKmCharges = extraKm * extraKmRate;

        // Totals
        const totalBeforeTax = subtotal + additional + waitingCharges + night + extraKmCharges;
        const gstRate = parseFloat(elements.gstRate.value) || 0;
        const gstAmount = totalBeforeTax * gstRate / 100;
        
        // Round off calculation
        const grandTotal = totalBeforeTax + gstAmount;
        const roundedTotal = Math.round(grandTotal);
        const roundOff = roundedTotal - grandTotal;

        // Update displays
        displays.subtotal.textContent = subtotal.toFixed(2);
        displays.subtotalVal.textContent = subtotal.toFixed(2);
        displays.additionalCharges.textContent = additional.toFixed(2);
        displays.waitingCharges.textContent = waitingCharges.toFixed(2);
        displays.waitingChargesTotal.textContent = waitingCharges.toFixed(2);
        displays.nightCharges.textContent = night.toFixed(2);
        displays.extraKmCharges.textContent = extraKmCharges.toFixed(2);
        displays.extraKmChargesTotal.textContent = extraKmCharges.toFixed(2);
        displays.totalBeforeTax.textContent = totalBeforeTax.toFixed(2);
        displays.gst.textContent = gstAmount.toFixed(2);
        displays.roundOff.textContent = roundOff.toFixed(2);
        displays.total.textContent = roundedTotal.toFixed(2);
        displays.termsExtraRate.textContent = extraKmRate;
    }

    // Add event listeners to all input fields
    Object.values(elements).forEach(element => {
        if (element) {
            element.addEventListener('input', recalc);
        }
    });

    // Sync distance fields
    const distanceField1 = document.getElementById('distance_km');
    const distanceField2 = document.getElementById('distance_km_input');
    
    distanceField1.addEventListener('input', function() {
        distanceField2.value = this.value;
        recalc();
    });
    
    distanceField2.addEventListener('input', function() {
        distanceField1.value = this.value;
        recalc();
    });

    // Initial calculation
    recalc();
});

function downloadPDF() {
    // Temporarily hide input fields and show values for PDF
    const originalInputs = document.querySelectorAll('input, textarea');
    const originalValues = [];
    
    originalInputs.forEach(input => {
        // Store original
        const originalType = input.type;
        const originalValue = input.value;
        const originalHTML = input.outerHTML;
        originalValues.push({ input, originalType, originalValue, originalHTML });
        
        // Replace with text for PDF
        if (input.type !== 'hidden') {
            const textSpan = document.createElement('span');
            textSpan.className = 'pdf-text-value fw-semibold';
            textSpan.textContent = originalValue || '-';
            textSpan.style.padding = '4px 8px';
            textSpan.style.display = 'inline-block';
            textSpan.style.minWidth = '50px';
            input.parentNode.replaceChild(textSpan, input);
        }
    });

    // Hide buttons for PDF
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => btn.style.display = 'none');
    
    const element = document.getElementById('invoiceArea');
    const opt = {
        margin: [0.5, 0.5, 0.5, 0.5],
        filename: `invoice-{{ $booking->id }}-{{ date('Y-m-d') }}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { 
            scale: 2,
            useCORS: true,
            logging: false
        },
        jsPDF: { 
            unit: 'in', 
            format: 'a4', 
            orientation: 'portrait' 
        }
    };
    
    html2pdf().set(opt).from(element).save().then(() => {
        // Restore original inputs after PDF generation
        originalValues.forEach(item => {
            if (item.input.parentNode) {
                item.input.parentNode.replaceChild(item.input, item.input.parentNode.querySelector('.pdf-text-value'));
            }
        });
        
        // Show buttons again
        buttons.forEach(btn => btn.style.display = '');
    });
}

function sendEmail() {
    alert('Email functionality would be implemented here. This would send the invoice to the customer\'s email.');
}

// Auto-save functionality
let saveTimeout;
function autoSave() {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => {
        const formData = new FormData();
        document.querySelectorAll('input, textarea').forEach(input => {
            formData.append(input.name, input.value);
        });
        
        fetch('{{ route("bookings.update-invoice", $booking->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            console.log('Invoice data saved');
        });
    }, 1000);
}

// Add input event listeners for auto-save
document.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('input', autoSave);
});
</script>
@endpush

@push('styles')
<style>
@media print {
    body * { visibility: hidden; }
    #invoiceArea, #invoiceArea * { 
        visibility: visible; 
        box-shadow: none !important;
    }
    #invoiceArea { 
        position: absolute; 
        left: 0; 
        top: 0; 
        width: 100%; 
        margin: 0;
        padding: 0;
    }
    .btn { display: none !important; }
    .card { border: 1px solid #ddd !important; }
    
    /* Hide input borders and show as text in print */
    input, textarea {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
    }
    input:focus, textarea:focus {
        outline: none !important;
    }
}

/* PDF text value styling */
.pdf-text-value {
    font-weight: 600;
    color: #333;
}

.table-primary th {
    background-color: #4a6cf7 !important;
    color: white;
    border: none;
}

.form-control {
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4a6cf7;
    box-shadow: 0 0 0 0.2rem rgba(74, 108, 247, 0.25);
}
</style>
@endpush