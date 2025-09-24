<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your Kodex Account Has Been Deleted</title>
    <style>
        /* Reset styles for email client compatibility */
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #1a202c;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            width: 100% !important;
            min-width: 100%;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
        }
        img {
            border: 0;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
            height: auto;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        .email-wrapper {
            width: 100%;
            background: #f1f5f9;
            padding: 20px 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .header {
            background: #E68815;
            padding: 30px;
            text-align: center;
        }
        .logo-container {
            text-align: center;
        }
        .logo-img {
            max-width: 150px;
            height: auto;
            display: block;
            margin: 0 auto 10px;
        }
        .welcome-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.9);
            color: #1a202c;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        .content {
            padding: 30px 20px;
            text-align: center;
        }
        .greeting {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 10px;
            color: #E68815;
        }
        .subtitle {
            font-size: 16px;
            color: #6b7280;
            margin: 0 0 20px;
        }
        .notice {
            background: #fff5f5;
            border: 1px solid #e53e3e;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            text-align: left;
        }
        .notice p {
            margin: 0;
            color: #92400e;
        }
        .content ul {
            padding-left: 20px;
            margin: 0 0 20px;
            color: #374151;
            font-size: 14px;
            text-align: left;
        }
        .content ul li {
            margin-bottom: 10px;
        }
        .support-text {
            background: #fef3c7;
            border: 1px solid #E68815;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .support-text p {
            margin: 0;
            color: #92400e;
            font-size: 14px;
        }
        .support-email {
            color: #a16207 !important;
            font-weight: bold;
            text-decoration: none;
        }
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            margin: 4px 0;
            font-size: 12px;
            color: #6b7280;
        }
        .social-links {
            margin: 15px 0 0;
        }
        .social-link {
            display: inline-block;
            margin: 0 6px;
            text-decoration: none;
        }
        .social-img {
            width: 24px;
            height: 24px;
            vertical-align: middle;
        }
        /* Media Queries for Responsiveness */
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 10px;
            }
            .container {
                width: 100% !important;
                border-radius: 0;
                border-left: 0;
                border-right: 0;
            }
            .header {
                padding: 20px;
            }
            .logo-img {
                max-width: 120px;
            }
            .content {
                padding: 20px 15px;
            }
            .greeting {
                font-size: 20px;
            }
            .subtitle {
                font-size: 14px;
            }
            .notice {
                padding: 10px;
                margin: 15px 0;
            }
            .notice p {
                font-size: 12px;
            }
            .content ul {
                font-size: 12px;
                padding-left: 15px;
            }
            .support-text {
                padding: 10px;
                margin: 15px 0;
            }
            .support-text p {
                font-size: 12px;
            }
            .footer {
                padding: 15px;
            }
            .footer p {
                font-size: 11px;
            }
            .social-img {
                width: 20px;
                height: 20px;
            }
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <table class="container" align="center" role="presentation">
        <tr>
            <td>
                <div class="header">
                    <div class="logo-container">
                        <img src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="{{ config('app.name') }} Learning Logo" class="logo-img">
                        <div class="welcome-badge">Account Deletion Notice</div>
                    </div>
                </div>
                <div class="content">
                    <h1 class="greeting">Your Kodex Account Has Been Deleted</h1>
                    <p class="subtitle">Dear {{ $user->name }},</p>
                    <div class="notice">
                        <p>We're confirming that your Kodex account (<strong>{{ $user->email }}</strong>) and all associated data have been permanently deleted from our systems.</p>
                    </div>
                    <p>Important information about your account deletion:</p>
                    <ul>
                        <li>All personal data has been removed from our active databases</li>
                        <li>Backup copies will be completely purged within 30 days</li>
                        <li>This action cannot be undone</li>
                    </ul>
                    <div class="support-text">
                        <p>If you didn't request this deletion or believe this was done in error, please contact our support team immediately at <a href="mailto:{{ site_settings()?->site_email }}" class="support-email">{{ site_settings()?->site_email }}</a>.</p>
                    </div>
                    <p>We're sorry to see you go and hope you'll consider rejoining us in the future.</p>
                    <p>Best regards,<br>The {{ config('app.name') }} Team</p>
                </div>
                <div class="footer">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }} Learning Platform. All rights reserved.</p>
                    <p>Empowering learners worldwide</p>
                    <p style="font-size: 11px; color: #9ca3af; margin-top: 8px;">
                        This is an automated message. Please do not reply directly to this email.
                    </p>
                    <div class="social-links">
                        <a href="{{ site_settings()?->site_fb }}" class="social-link" title="Facebook">
                            <img src="https://img.icons8.com/color/24/000000/facebook-new.png" alt="Facebook" class="social-img">
                        </a>
                        <a href="{{ site_settings()?->site_instagram }}" class="social-link" title="Instagram">
                            <img src="https://img.icons8.com/color/24/000000/instagram.png" alt="Instagram" class="social-img">
                        </a>
                        <a href="{{ site_settings()?->site_linkedin }}" class="social-link" title="LinkedIn">
                            <img src="https://img.icons8.com/color/24/000000/linkedin.png" alt="LinkedIn" class="social-img">
                        </a>
                        <a href="{{ site_settings()?->site_youtube }}" class="social-link" title="YouTube">
                            <img src="https://img.icons8.com/color/24/000000/youtube-play.png" alt="YouTube" class="social-img">
                        </a>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
