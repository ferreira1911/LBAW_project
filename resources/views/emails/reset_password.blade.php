<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Hello, {{ $mailData['name'] }}</h2>
    
    <p>You are receiving this email because we received a password reset request for your account.</p>
    
    <p>Click the link below to reset your password:</p>
    
    <a href="{{ $mailData['url'] }}" style="background-color: #9b4dca; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Reset Password
    </a>
    
    <p>This link will expire in 60 minutes.</p>
    
    <p>If you did not request a password reset, no further action is required.</p>
    
    <br>
    <p>Regards,<br>AuctionEase Team</p>
</body>
</html>