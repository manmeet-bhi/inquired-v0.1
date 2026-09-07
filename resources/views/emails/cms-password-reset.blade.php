<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Your CMS Password</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: white; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: white; color: #4f46e5; padding: 20px; text-align: center; }
        .header img { max-height: 50px; margin-bottom: 10px; }
        .content { background: white; padding: 30px; }
        .button { display: inline-block; background: white; color: #4f46e5; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; font-weight: 600; border: 2px solid #4f46e5; }
        .button:hover { background-color: #f3f4f6; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/logos/logo.png') }}" alt="Inaquired Logo">
            <h1>Reset Your Inaquired Desk Password</h1>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            
            <p>You are receiving this email because we received a password reset request for your Inaquired Desk account.</p>
            
            <p>Click the button below to reset your password:</p>
            
            <a href="{{ route('cms.password.reset', ['token' => $token, 'email' => $email]) }}" class="button">Reset Password</a>
            
            <p>If you're having trouble clicking the button, copy and paste the URL below into your web browser:</p>
            <p><a href="{{ route('cms.password.reset', ['token' => $token, 'email' => $email]) }}">{{ route('cms.password.reset', ['token' => $token, 'email' => $email]) }}</a></p>
            
            <p>This password reset link will expire in 60 minutes.</p>
            
            <p>If you did not request a password reset, no further action is required.</p>
            
            <p>Best regards,<br>Inaquired</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Inaquired. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
