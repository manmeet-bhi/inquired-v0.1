<!DOCTYPE html>
<html>
<head>
    <style>
        .container { font-family: sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .code-box { background: #f3f4f6; border-radius: 8px; padding: 20px; text-align: center; font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #2563eb; }
        .footer { margin-top: 30px; font-size: 12px; color: #6b7280; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Two-Factor Authentication</h2>
        </div>
        <p>Hello {{ $user->name }},</p>
        <p>Your two-factor authentication code is:</p>
        <div class="code-box">
            {{ $code }}
        </div>
        <p>This code will expire in 10 minutes.</p>
        <p>If you did not request this code, please secure your account immediately.</p>
        <div class="footer">
            &copy; {{ date('Y') }} Anywhereroles. All rights reserved.
        </div>
    </div>
</body>
</html>
