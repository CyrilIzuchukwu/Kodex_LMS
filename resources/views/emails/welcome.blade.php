<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome to {{ config('app.name') }} Learning</title>
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
        .user-info {
            background: #fef3c7;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #E68815;
        }
        .user-email-label {
            font-size: 12px;
            color: #a16207;
            margin: 0 0 6px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .user-email {
            font-size: 14px;
            color: #92400e;
            margin: 0;
            font-weight: bold;
        }
        .cta-section {
            margin: 30px 0;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #E68815;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
        }
        .features {
            margin: 30px 0;
        }
        .feature {
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            margin: 10px 0;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .feature-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .feature-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin: 0 0 6px;
        }
        .feature-desc {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }
        .next-steps {
            background: #e0f2fe;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        .next-steps h3 {
            color: #0c4a6e;
            margin: 0 0 12px;
            font-size: 16px;
            font-weight: bold;
        }
        .step-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
            color: #374151;
            font-size: 14px;
        }
        .step-bullet {
            width: 10px;
            height: 10px;
            background: #E68815;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 5px;
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
            .content {
                padding: 20px 15px;
            }
            .greeting {
                font-size: 20px;
            }
            .subtitle {
                font-size: 14px;
            }
            .user-info {
                padding: 15px;
                margin: 15px 0;
            }
            .button {
                padding: 10px 20px;
                font-size: 14px;
                display: block;
                width: auto;
                max-width: 200px;
                margin: 0 auto;
            }
            .features {
                margin: 20px 0;
            }
            .feature {
                padding: 15px;
                margin: 10px 0;
            }
            .feature-icon {
                font-size: 20px;
            }
            .feature-title {
                font-size: 14px;
            }
            .feature-desc {
                font-size: 12px;
            }
            .next-steps {
                padding: 15px;
                margin: 15px 0;
                text-align: center;
            }
            .next-steps h3 {
                font-size: 14px;
            }
            .step-item {
                font-size: 12px;
                text-align: left;
                justify-content: flex-start;
                padding: 0 10px;
            }
            .step-bullet {
                width: 8px;
                height: 8px;
                margin-top: 4px;
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
                        <div class="welcome-badge">Start Learning Today!</div>
                    </div>
                </div>
                <div class="content">
                    <h1 class="greeting">Welcome, {{ $user->name }}!</h1>
                    <p class="subtitle">Your learning journey starts here</p>
                    <div class="user-info">
                        <p class="user-email-label">Your Learning Account</p>
                        <p class="user-email">{{ $user->email }}</p>
                    </div>
                    <p>Congratulations on joining {{ config('app.name') }} Learning! You've taken the first step towards mastering new skills and advancing your career. Your account is now active and ready to explore our comprehensive learning platform.</p>
                    <div class="features">
                        <div class="feature">
                            <div class="feature-icon" role="img" aria-label="Book icon">📚</div>
                            <div class="feature-title">Expert Courses</div>
                            <div class="feature-desc">Learn from industry professionals with hands-on projects</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon" role="img" aria-label="Trophy icon">🏆</div>
                            <div class="feature-title">Certificates</div>
                            <div class="feature-desc">Earn recognized certificates upon course completion</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon" role="img" aria-label="People icon">👥</div>
                            <div class="feature-title">Community</div>
                            <div class="feature-desc">Connect with peers and get support from mentors</div>
                        </div>
                    </div>
                    <div class="cta-section">
                        <a href="{{ route('user.dashboard') }}" class="button">Start Learning Now</a>
                    </div>
                    <div class="next-steps">
                        <h3>Your Next Steps</h3>
                        <ul class="step-list">
                            <li class="step-item">
                                <span class="step-bullet"></span>
                                <span>Complete your profile and set your learning goals</span>
                            </li>
                            <li class="step-item">
                                <span class="step-bullet"></span>
                                <span>Browse our course catalog and enroll in your first course</span>
                            </li>
                            <li class="step-item">
                                <span class="step-bullet"></span>
                                <span>Join our community forums and introduce yourself</span>
                            </li>
                            <li class="step-item">
                                <span class="step-bullet"></span>
                                <span>Set up your study schedule and learning preferences</span>
                            </li>
                        </ul>
                    </div>
                    <div class="support-text">
                        <p>Need help getting started? Our learning support team is available 24/7 to guide you through your educational journey. Contact us at <a href="mailto:{{ site_settings()?->site_email }}" class="support-email">{{ site_settings()?->site_email }}</a></p>
                    </div>
                </div>
                <div class="footer">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }} Learning Platform. All rights reserved.</p>
                    <p>Empowering learners worldwide</p>
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
