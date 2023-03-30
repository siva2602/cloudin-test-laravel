<!DOCTYPE html>
<html>
<head>
    <title>Registration Confirmation</title>
</head>
<body>
<p>Dear {{ $user->name }},</p>
<p>Thank you for registering for our service! Please click the link below to confirm your registration:</p>
<p><a href="{{ $verification_url }}">{{ $verification_url }}</a></p>
<p>Thank you,</p>
<p>The Example Team</p>
</body>
</html>
