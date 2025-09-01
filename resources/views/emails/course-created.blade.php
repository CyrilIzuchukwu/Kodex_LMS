<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Created Successfully</title>
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
            <h1>Congratulations, {{ $user->name }}!</h1>
            <p>Your course, "{{ $course->title }}", has been successfully created on Kodex.</p>
            <p>You're ready to share your knowledge with the world! Your course is now available for review and will be accessible to students once approved.</p>
            <p>Course Details:</p>
            <p>Course Name: {{ $course->title }}</p>
            <p>Category: {{ $course->category->name }}</p>
            <a href="{{ route('admin.courses.index') }}" class="button">View Your Course</a>
            <p>If you have any questions or need assistance, our support team is here to help. Contact us at support@kodex.com.</p>
        </div>
    </div>
</body>
</html>
