<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #334155; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .codes-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #f8fafc; padding: 20px; border-radius: 8px; font-family: monospace; font-size: 16px; font-weight: bold; text-align: center; }
        .footer { margin-top: 30px; font-size: 12px; color: #64748b; text-align: center; }
        .warning { color: #dc2626; font-weight: bold; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Backup Recovery Codes</h2>
        </div>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>You requested your 2FA backup recovery codes. Please keep these codes in a safe place. Each code can only be used once.</p>
        
        <p class="warning">Warning: Do not share these codes with anyone. They can be used to access your account if you lose your 2FA device.</p>
        
        <div class="codes-grid">
            @foreach($codes as $code)
                <div style="padding: 10px; border: 1px solid #e2e8f0; background: white;">{{ $code }}</div>
            @endforeach
        </div>
        
        <p style="margin-top: 20px;">If you did not request these codes, please secure your account immediately.</p>
        
        <div class="footer">
            &copy; {{ date('Y') }} Anywhereroles Desk. All rights reserved.
        </div>
    </div>
</body>
</html>
