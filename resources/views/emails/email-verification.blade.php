<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Kodex OTP Code</title>
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
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #2563eb;
            text-align: center;
            padding: 16px;
            background: #f8fafc;
            border-radius: 6px;
            letter-spacing: 4px;
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
            .otp-code {
                font-size: 24px;
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
        <h1>Your One-Time Password</h1>
        <p>Hello,</p>
        <p>You've requested a one-time password to verify your identity. Please use the code below to proceed:</p>
        <div class="otp-code">{{ $token }}</div>
        <p>This code is valid for the next 20 minutes. Do not share it with anyone.</p>
        <p>If you didn't request this OTP, please contact our support team immediately at support@kodex.com.</p>
        <a href="{{ config('app.url') }}" class="button">Return to site</a>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Kodex. All rights reserved.</p>
        <p>123 Business Street, Tech City</p>
    </div>
</div>
</body>
</html>
