<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Course Purchase Invoice</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                background-color: #f5f5f5;
                color: #333;
                line-height: 1.6;
            }
            .container {
                max-width: 600px;
                margin: 40px auto;
                background: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .header {
                background: #2563eb;
                padding: 24px;
                text-align: center;
            }
            .header img {
                max-width: 120px;
                height: auto;
            }
            .content {
                padding: 32px;
            }
            .content h1 {
                font-size: 24px;
                margin: 0 0 16px;
                color: #1f2937;
            }
            .content p {
                margin: 0 0 16px;
                color: #4b5563;
            }
            .invoice-details {
                margin: 16px 0;
                padding: 16px;
                background: #f8fafc;
                border: 1px solid #e5e7eb;
                border-radius: 6px;
            }
            .invoice-details p {
                margin: 8px 0;
            }
            .invoice-table {
                width: 100%;
                border-collapse: collapse;
                margin: 16px 0;
            }
            .invoice-table th,
            .invoice-table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #e5e7eb;
            }
            .invoice-table th {
                background: #f1f5f9;
                color: #1f2937;
                font-weight: 500;
            }
            .invoice-table .total {
                font-weight: 600;
                color: #1f2937;
            }
            .button {
                display: inline-block;
                padding: 12px 24px;
                background: #2563eb;
                color: #ffffff !important;
                text-decoration: none;
                border-radius: 6px;
                font-weight: 500;
                margin: 16px 0;
                text-align: center;
            }
            .footer {
                background: #f8fafc;
                padding: 24px;
                text-align: center;
                font-size: 14px;
                color: #6b7280;
            }
            @media (max-width: 600px) {
                .container {
                    margin: 20px;
                }
                .content {
                    padding: 24px;
                }
                .invoice-table th,
                .invoice-table td {
                    padding: 8px;
                }
            }
        </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="Kodex Logo">
        </div>
        <div class="content">
            <h1>Invoice for Your Course Purchase</h1>
            <p>Dear {{ $user->name }},</p>
            <p>Thank you for your purchase on Kodex. This email serves as your official receipt for invoice #{{ $payment->transaction_reference }} issued on {{ $payment->created_at->format('F j, Y') }}.</p>

            <div class="invoice-details">
                <p><strong>Transaction ID:</strong> {{ $payment->transaction_reference }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($payment->status) }}</p>
                <p><strong>Date:</strong> {{ $payment->created_at->format('F j, Y') }}</p>
            </div>

            <h2>Purchase Details</h2>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Category</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        @php
                            $cartItem = collect(json_decode($payment->cart_items, true))->firstWhere('course_id', $course->id);
                            $price = $cartItem['price'] ?? 'N/A';
                        @endphp
                        <tr>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->category->name ?? 'N/A' }}</td>
                            <td>₦ {{ number_format($price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="total">Subtotal</td>
                        <td class="total">₦ {{ number_format($payment->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Charges</td>
                        <td>₦ {{ number_format($payment->charges, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Discount</td>
                        <td>₦ {{ number_format($payment->discount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="total">Total</td>
                        <td class="total">₦ {{ number_format($payment->subtotal + $payment->charges - $payment->discount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <p>You can access your {{ $courses->count() > 1 ? 'courses' : 'course' }} at any time by logging into your dashboard.</p>
            <a href="{{ route('user.course.my.learning') }}" class="button">View Your Courses</a>

            <p>If you have any questions or need assistance, our support team is here to help. Contact us at <a href="mailto:support@kodex.com">support@kodex.com</a>.</p>
            <p><strong>Note:</strong> This email serves as your official receipt for this payment.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Kodex. All rights reserved.</p>
        </div>
    </div>
    </body>
</html>
