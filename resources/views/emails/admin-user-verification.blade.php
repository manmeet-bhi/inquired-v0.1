<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Account</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .button { display: inline-block; padding: 12px 24px; background-color: #4F46E5; color: #ffffff !important; text-decoration: none; border-radius: 5px; margin-top: 20px; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 0.8em; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $user->name }},</h2>
        <p>You have been invited to join the Anywhereroles Desk CMS as an admin.</p>
        <p>Please click the button below to verify your email address and activate your account. This link is valid for 7 days.</p>
        
        <a href="{{ $verificationUrl }}" class="button" style="color: #ffffff; background-color: #4F46E5;">Verify Email Address</a>
        
        <p>If you did not expect this email, no further action is required.</p>
        
        <div class="footer">
            <p>If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:</p>
            <p>{{ $verificationUrl }}</p>
        </div>
    </div>
</body>
</html>
