<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Kodex Account Has Been Deleted</title>
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
            background: #e53e3e;
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
        .notice {
            background-color: #fff5f5;
            border-left: 4px solid #e53e3e;
            padding: 16px;
            margin: 20px 0;
            font-size: 15px;
        }
        .footer {
            background: #f8fafc;
            padding: 24px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
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
        <h1>Your Kodex Account Has Been Deleted</h1>
        <p>Dear {{ $user->name }},</p>

        <div class="notice">
            <p>We're confirming that your Kodex account (<strong>{{ $user->email }}</strong>) and all associated data have been permanently deleted from our systems.</p>
        </div>

        <p>Important information about your account deletion:</p>
        <ul style="padding-left: 20px; margin-bottom: 20px;">
            <li>All personal data has been removed from our active databases</li>
            <li>Backup copies will be completely purged within 30 days</li>
            <li>This action cannot be undone</li>
        </ul>

        <p>If you didn't request this deletion or believe this was done in error, please contact our support team immediately at <a href="mailto:support@kodex.com">support@kodex.com</a>.</p>

        <p>We're sorry to see you go and hope you'll consider rejoining us in the future.</p>

        <p>Best regards,<br>The Kodex Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Kodex. All rights reserved.</p>
        <p>123 Business Street, Tech City</p>
        <p style="font-size: 13px; color: #9ca3af; margin-top: 8px;">
            This is an automated message. Please do not reply directly to this email.
        </p>
    </div>
</div>
</body>
</html>
