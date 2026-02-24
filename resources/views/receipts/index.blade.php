<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BookMe - Shipment Receipt</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff;
      color: #333;
      padding: 30px;
      max-width: 800px;
      margin: auto;
      border: 1px solid #ddd;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #eee;
      padding-bottom: 15px;
      margin-bottom: 20px;
    }

    .header .logo img {
      height: 60px;
    }

    .company-info {
      text-align: right;
      font-size: 14px;
      line-height: 1.5;
    }

    h2 {
      margin-top: 0;
      font-size: 22px;
    }

    .section {
      margin-bottom: 25px;
    }

    .section-title {
      font-weight: bold;
      margin-bottom: 8px;
      font-size: 16px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    table th,
    table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    .order-summary {
      border-top: 2px solid #eee;
      padding-top: 15px;
    }

    .summary-line {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }

    .summary-line strong {
      font-weight: bold;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 14px;
      color: #666;
    }

    .payment-method {
      margin-top: 15px;
    }

    .payment-method span {
      font-weight: bold;
    }

    .shipment-title {
      font-weight: bold;
      font-size: 20px;
      text-align: center;
    }

    .bookme-txt {
      font-size: 20px;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <div class="logo">
      <img src="/logo.png" alt="BookMe Logo">
    </div>
    <div class="company-info">
      <strong class="bookme-txt">BookMe</strong><br>
      1147/A (3rd floor), CDA Avenue,<br> GEC Circle, Chattogram<br>
      Phone: +8801967776777<br>
      Email: bookmebdltd@gmail.com
    </div>
  </div>

  <!--<p class="shipment-title">Shipment Receipt</p>-->

  <p>Dear <strong>OMAR</strong>,</p>

  <p>
    Thank you for choosing <strong>Book Me</strong>. Your shipment from 
    <strong>Khulna</strong> to <strong>Sundarban</strong> has been 
    successfully booked and confirmed on 
    <strong>Mon, 10 Mar 2025 – 10:05 AM</strong>.
  </p>

  <!-- Customer Table -->
  <div class="section">
    <div class="section-title">Customer Details</div>
    <table>
      <thead>
        <tr>
          <th>Customer Name</th>
          <th>Customer Phone</th>
          
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>John Doe</td>
          <td>+880 1711 123456</td>
          
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Order Summary -->
  <div class="section order-summary">
    <div class="section-title">Order Summary</div>
    <div class="summary-line"><span>Subtotal:</span> <span>৳500</span></div>
    <div class="summary-line"><span>Shipping:</span> <span>৳80</span></div>
    <div class="summary-line"><span>Discount:</span> <span>-৳50</span></div>
    <div class="summary-line"><span>Advance Payment:</span> <span>৳300</span></div>
    <div class="summary-line"><strong>Total:</strong> <strong>৳530</strong></div>
    <div class="summary-line"><span>Paid:</span> <span>৳300</span></div>
    <div class="summary-line"><span>Payment Due:</span> <span>৳230</span></div>

    <div class="payment-method">
      <span>Payment Method:</span> Cash
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    Thank you for using BookMe!<br>
    For support, call +880 1234 567890 or visit our website.<br><br>
    <em>Printed on: October 22, 2025</em>
  </div>

</body>
</html>
