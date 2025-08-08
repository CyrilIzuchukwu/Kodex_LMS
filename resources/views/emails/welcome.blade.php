<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Kodex</title>
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
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="Kodex Logo">
    </div>
    <div class="content">
        <h1>Welcome, {{ $user->name }}!</h1>
        <p>Thank you for joining Kodex. Your account has been successfully created, and you're ready to start exploring our platform.</p>
        <p>Your registered email: {{ $user->email }}</p>
        <p>Get started by exploring your dashboard.</p>
        <a href="{{ route('user.dashboard') }}" class="button">Go to Dashboard</a>
        <p>If you have any questions, our support team is here to help. Contact us at support@kodex.com.</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Kodex. All rights reserved.</p>
        <p>123 Business Street, Tech City</p>
    </div>
</div>
</body>
</html>
