<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>

    <p>I hope this message finds you well.</p>

    <p>I am pleased to inform you that your account has been successfully created. <strong>Welcome to {{ get_option('site_name') }}!</strong> We are excited to have you join us and look forward to seeing the great things we will accomplish together.</p>

    <p>Should you have any questions or require further information, please do not hesitate to reach out. We are here to assist you every step of the way.</p>

    <p>Thank you for choosing to be a part of our community.</p>

    <p>Warm regards,<br>
    {{ get_option('site_name') }}<br>
    {{ get_option('contact_phone') }}</p>
</body>
</html>
