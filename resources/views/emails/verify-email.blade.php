<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your TapeventCard email</title>
</head>

<body style="margin:0;background:#f5f5f7;color:#1d1d1f;font-family:Arial,sans-serif;line-height:1.6;">
    <div style="padding:48px 20px;">
        <div
            style="max-width:560px;margin:0 auto;background:#ffffff;border:1px solid #e5e5e7;border-radius:24px;padding:40px 32px;">
            <div style="text-align:center;margin-bottom:30px;">
                <div
                    style="width:48px;height:48px;margin:0 auto 16px;background:#1d1d1f;border-radius:14px;display:flex;align-items:center;justify-content:center;">
                    <img src="{{ asset('storage/logos/logo1.png') }}" alt="TapeventCard"
                        style="max-width:34px;max-height:34px;">
                </div>
                <h1 style="margin:0;font-size:26px;line-height:1.2;">Welcome to TapeventCard</h1>
            </div>

            <p style="margin:0 0 16px;">Hi {{ $user->name }},</p>
            <p style="margin:0 0 24px;color:#6e6e73;">Your account is almost ready. Verify your email address so you can
                sign in and start building unforgettable invitations.</p>

            <div style="text-align:center;margin:30px 0;">
                <a href="{{ $verificationUrl }}"
                    style="display:inline-block;background:#e8120a;color:#ffffff;text-decoration:none;border-radius:999px;padding:14px 26px;font-weight:700;">Verify
                    my email</a>
            </div>

            <p style="margin:0;color:#6e6e73;font-size:14px;">This link expires in {{ $expiresIn }} minutes. If you
                did not create a TapeventCard account, you can safely ignore this email.</p>
            <p style="margin:24px 0 0;color:#a1a1a6;font-size:13px;">If the button does not work, copy this link into
                your browser:<br><a href="{{ $verificationUrl }}"
                    style="color:#e8120a;word-break:break-all;">{{ $verificationUrl }}</a></p>
        </div>
    </div>
</body>

</html>
