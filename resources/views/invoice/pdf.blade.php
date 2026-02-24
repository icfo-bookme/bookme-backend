<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payment Invoice #{{ $order->orderno }}</title>
    <style>
        /* Modern clean design matching the image */
        @page {
            margin: 15mm;
        }
        @font-face {
        font-family: 'SolaimanLipi';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('font/SolaimanLipi_22-02-2012.ttf') }}") format('truetype');
    }
        
        body {
            font-family: 'SolaimanLipi', sans-serif;
            margin: 0;
            padding: 0;
            color: #2d3748;
            line-height: 1.6;
            font-size: 14px;
        }
        
        .invoice-wrapper {
            max-width: 800px;
            margin: 0 auto;
            padding: 0px;
        }
        
        /* Header Section */
        .header-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #9CA3AF;
            padding-bottom: 7px;
            padding-top: 10px;
        }
        
        .logo-container {
            flex: 0 0 auto;
        }
        
        .company-logo {
            max-height: 80px;
            max-width: 180px;
            object-fit: contain;
        }
        
        .company-info {
            flex: 1;
            text-align: center;
        }
        
        .company-name {
            font-size: 32px;
            font-weight: bold;
            color: #1e40af;
            letter-spacing: 1px;
        }
        
        .invoice-title {
            font-size: 18px;
            font-weight: 600;
            color: #172554;
            margin: 10px 0;
        }
        
        .header-section.alternative {
            flex-direction: column;
            text-align: center;
            
        }
        
        .header-section.alternative .logo-container {
            margin-bottom: 0px;
        }
        
        /* Hotel & Invoice Info */
        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px;
            margin-bottom: 5px;
        }
        
        /*.hotel-info-box, .invoice-info-box {*/
        /*    background: #f8fafc;*/
        /*    padding: 15px;*/
        /*    border-radius: 8px;*/
        /*    border-left: 4px solid #3b82f6;*/
        /*}*/
        
        .section-label {
            font-size: 16px;
            font-weight: 600;
            color: #172554;
            margin-bottom: 10px;
            display: block;
        }
        
        .info-item {
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: 500;
            color: #172554;
             font-size: 17px;
            min-width: 120px;
            display: inline-block;
        }
        
       .info-value {
    position: relative;
    top: -5px;
    font-weight: 400;
    color: #1F2937;
}
        
        /* Guest Information */
        .guest-section {
            padding: 5px;
            margin-bottom: 5px;
        }
        
        .section-heading {
            font-size: 18px;
            font-weight: 600;
            color: #0369a1;
            margin-bottom: 15px;
            border-bottom: 2px solid #bae6fd;
            padding-bottom: 8px;
        }
        
        /* Stay Details */
        .stay-details {
          
            padding: 5px;
            margin-bottom: 5px;
        }
        
        /* Price Breakdown */
        .price-breakdown {
            margin-bottom: 30px;
        }
        
        .price-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .price-table tr {
            border-bottom: 1px solid #e5e7eb;
        }
        
        .price-table td {
            padding: 12px 8px;
            vertical-align: top;
        }
        
        .price-table .label {
            width: 70%;
            color: #4b5563;
            font-weight: 500;
        }
        
        .price-table .amount {
            width: 30%;
            text-align: right;
            font-weight: 600;
            color: #1f2937;
        }
        
        /* Grand Total Section */
        .grand-total-section {
            background: #1e40af;
            color: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .grand-total-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .payment-row:last-child {
            border-bottom: none;
            border-top: 2px solid rgba(255, 255, 255, 0.3);
            font-size: 18px;
            font-weight: 700;
            margin-top: 10px;
        }
        
        /* Footer */
        .footer-section {
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            margin-top: 30px;
        }
        
        .footer-links {
            margin-top: 10px;
        }
        
        .footer-links a {
            color: #3b82f6;
            text-decoration: none;
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-confirmed { background: #d1fae5; color: #065f46; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-unpaid { background: #fee2e2; color: #dc2626; }
        
        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #172554, transparent);
            margin: 25px 0;
        }
        
        /* Room Details */
        .room-features {
            background: #fefce8;
            padding: 12px;
            border-radius: 6px;
            margin-top: 10px;
            font-size: 13px;
            color: #854d0e;
        }
        
        /* Logo placeholder styling */
        .logo-placeholder {
            width: 180px;
            height: 80px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 24px;
        }
        
        .hotel_name{
            padding-top: 15px;
            margin-top: 5px;
        }
        .input-flex{
            display: flex;
        }
    </style>
</head>
<body>
    <div class="invoice-wrapper">
        
       
        <div class="header-section alternative">
            <div class="logo-container">
               <img src="{{ public_path('images/png.png') }}" width="150">
            </div>
            <div class="company-info">
                <div class="invoice-title">PAYMENT INVOICE </div>
            </div>
        </div>
        
        
        <!-- Hotel & Invoice Information -->
        <div class="info-section">
            @if($order->bookingDetails && count($order->bookingDetails) > 0)
                @php $detail = $order->bookingDetails->first(); @endphp
                @if($detail->room && $detail->room->hotel)
                <div class="input-flex">
                <div class="hotel-info-box">
                    <div class="info-item">
                    <span class="info-label hotel_name">Invoice No.:</span>
                    <span class="info-value">{{ $order->orderno }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Invoice Date:</span>
                    <span class="info-value">{{ date('d-M-y', strtotime($order->order_date)) }}</span>
                </div>
                </div>
                    <div class="info-item">
                        <span st class="info-label ">Hotel Name:</span>
                        <span class="info-value">{{ $detail->room->hotel->name ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Location:</span>
                        <span class="info-value">{{ $detail->room->hotel->city ?? '' }}</span>
                    </div>
                </div>
                @endif
            @endif
            
            <!--<div class="invoice-info-box">-->
            <!--    <span class="section-label">Invoice Details</span>-->
                
                
            <!--    <div class="info-item">-->
            <!--        <span class="info-label">Status:</span>-->
            <!--        <span class="info-value">{{ ucfirst($order->order_status) }}</span>-->
            <!--        <span class="status-badge status-{{ $order->order_status }}">-->
            <!--            {{ $order->order_status }}-->
            <!--        </span>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
        

        
        <!-- Guest Information -->
        <div class="guest-section">
            <div class="section-heading">Guest Information</div>
            <div class="info-item">
                <span class="info-label">Guest Name:</span>
                <span class="info-value">{{ $order->customer_name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone Number:</span>
                <span class="info-value">{{ $order->mobile_no }}</span>
            </div>
            @if($order->purchaser)
            <div class="info-item">
                <span class="info-label">Purchaser:</span>
                <span class="info-value">{{ $order->purchaser }}</span>
            </div>
            @endif
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $order->email ?? 'N/A' }}</span>
            </div>
        </div>
        
        @if($order->bookingDetails && count($order->bookingDetails) > 0)
            @foreach($order->bookingDetails as $detail)
                <!-- Room Information -->
                <div class="guest-section" >
                    <div class="section-heading">Room Details</div>
                    <div class="info-item">
                        <span class="info-label">Room Type:</span>
                        <span class="info-value">{{ $detail->room->name ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Room View:</span>
                        <span class="info-value">{{ $detail->room->room_view ?? 'Standard' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Guests:</span>
                        <span class="info-value">{{ $detail->total_guests }} Adults, 0 Children</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Breakfast:</span>
                        <span class="info-value">{{ ucfirst($detail->room->breakfast_status ?? 'not included') }}</span>
                    </div>
                    
                    @if($detail->room->room_characteristics)
                    <div class="room-features">
                        <strong>Room Features:</strong> {{ $detail->room->room_characteristics }}
                    </div>
                    @endif
                </div>
                
                <!-- Stay Details -->
                <div class="stay-details">
                    <div class="section-heading">Stay Details</div>
                    <div class="info-item">
                        <span class="info-label">Check-in:</span>
                        <span class="info-value">{{ date('l, F d, Y', strtotime($detail->check_in_date)) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Check-out:</span>
                        <span class="info-value">{{ date('l, F d, Y', strtotime($detail->check_out_date)) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Nights:</span>
                        <span class="info-value">
                            @php
                                $checkIn = new DateTime($detail->check_in_date);
                                $checkOut = new DateTime($detail->check_out_date);
                                $nights = $checkIn->diff($checkOut)->days;
                            @endphp
                            {{ $nights }}
                        </span>
                    </div>
                </div>
            @endforeach
        @endif
        
        <!-- Price Breakdown -->
        <div class="price-breakdown">
            <div class="section-heading" style="background: transparent; padding: 0; border-bottom: 2px solid #3b82f6;">
                Price Breakdown
            </div>
            
            @if($order->bookingDetails && count($order->bookingDetails) > 0)
                @php
                    $detail = $order->bookingDetails->first();
                    $checkIn = new DateTime($detail->check_in_date);
                    $checkOut = new DateTime($detail->check_out_date);
                    $nights = $checkIn->diff($checkOut)->days;
                    $roomTotal = $detail->price_per_night * $nights;
                    
                    // Calculate VAT and Service Charge if available
                    $vat = $detail->room->hotel->vat ?? 0;
                    $serviceCharge = $detail->room->hotel->service_charge ?? 0;
                    
                    $vatAmount = $roomTotal * ($vat / 100);
                    $serviceAmount = $roomTotal * ($serviceCharge / 100);
                    
                    // Calculate discount (5% as per your image example)
                    $discountPercentage = 5;
                    $discountAmount = $roomTotal * ($discountPercentage / 100);
                    $totalAfterDiscount = $roomTotal - $discountAmount;
                    
                    $grandTotal = $totalAfterDiscount + $vatAmount + $serviceAmount;
                @endphp
                
                <table class="price-table">
                    <tr>
                        <td class="label">Room Rate per Night:</td>
                        <td class="amount">{{ number_format($detail->price_per_night, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <td class="label">Number of Nights:</td>
                        <td class="amount">{{ $nights }} Nights</td>
                    </tr>
                    <tr>
                        <td class="label">Room Total:</td>
                        <td class="amount">{{ number_format($roomTotal, 2) }} BDT</td>
                    </tr>
                    
                    @if($vat > 0)
                    <tr>
                        <td class="label">Government Taxes & Fees (VAT {{ $vat }}%):</td>
                        <td class="amount">{{ number_format($vatAmount, 2) }} BDT</td>
                    </tr>
                    @endif
                    
                    @if($serviceCharge > 0)
                    <tr>
                        <td class="label">Service Charge ({{ $serviceCharge }}%):</td>
                        <td class="amount">{{ number_format($serviceAmount, 2) }} BDT</td>
                    </tr>
                    @endif
                    
                    <tr>
                        <td class="label">Discount ({{ $discountPercentage }}%):</td>
                        <td class="amount">-{{ number_format($discountAmount, 2) }} BDT</td>
                    </tr>
                    <tr style="border-top: 2px solid #3b82f6;">
                        <td class="label"><strong>Paid Amount: </strong></td>
                        <td class="amount"><strong>{{ number_format($order->total_paid ?? 0, 2) }} BDT</strong></td>
                    </tr>
                    <tr style="border-top: 2px solid #3b82f6;">
                        <td class="label"><strong>Total Payable:</strong></td>
                        <td class="amount"><strong>{{ number_format($grandTotal, 2) }} BDT</strong></td>
                    </tr>
                    
                </table>
            @endif
        </div>
        
        <!-- Grand Total -->
        <!--<div class="grand-total-section">-->
        <!--    <div class="grand-total-title">GRAND TOTAL</div>-->
            
        <!--    <div class="payment-row">-->
        <!--        <span>Paid Amount</span>-->
        <!--        <span>{{ number_format($order->total_paid ?? 0, 2) }} BDT</span>-->
        <!--    </div>-->
            
        <!--    <div class="payment-row">-->
        <!--        <span>Due</span>-->
        <!--        <span>{{ number_format($grandTotal - ($order->total_paid ?? 0), 2) }} BDT</span>-->
        <!--    </div>-->
            
        <!--    <div class="payment-row">-->
        <!--        <span>Total Payable</span>-->
        <!--        <span>{{ number_format($grandTotal, 2) }} BDT</span>-->
        <!--    </div>-->
        <!--</div>-->
        
        <!-- Footer -->
        <div class="footer-section">
            <p>© {{ date('Y') }} BookMe.com.bd</p>
            <p>Your Trusted Travel Partner in Bangladesh</p>
            <div class="footer-links">
                <p>Email: support@bookme.com.bd | Phone: +880 1234 567890</p>
                <p><a href="https://www.bookme.com.bd">https://www.bookme.com.bd</a></p>
            </div>
            <p style="margin-top: 15px; font-size: 11px; color: #9ca3af;">
                This is a computer-generated invoice. No signature required.<br>
                Generated on: {{ date('d M, Y h:i A') }}
            </p>
        </div>
    </div>
    
    <script>
        // Fallback if logo image doesn't load
        document.addEventListener('DOMContentLoaded', function() {
            const logo = document.querySelector('.company-logo');
            const placeholder = document.querySelector('.logo-placeholder');
            
            if (logo) {
                logo.onerror = function() {
                    this.style.display = 'none';
                    if (placeholder) {
                        placeholder.style.display = 'flex';
                    }
                };
                
                // Check if image loaded successfully
                if (!logo.complete || logo.naturalWidth === 0) {
                    logo.onerror();
                }
            }
        });
    </script>
</body>
</html>