<!DOCTYPE html>
<html>

<head>
    <title>Invitation</title>
</head>

<body>
    <h2>Dear {{ $data['guest']->full_name }},</h2>
    <p>You are invited to <strong>{{ $data['event']->order_name }}</strong>.</p>
    <p>Date: {{ \Carbon\Carbon::parse($data['event']->event_date)->format('F j, Y') }}</p>
    <p>Time: {{ \Carbon\Carbon::parse($data['event']->arrival_time)->format('g:i A') }}</p>
    <p>Venue: {{ $data['event']->event_location }}</p>
    <p>Your QR Code: <a href="{{ $data['qr_url'] }}">View & Download</a></p>
    <p>Or preview your card: <a href="{{ $data['card_preview_url'] }}">Card Preview</a></p>
    <p>We look forward to seeing you!</p>
</body>

</html>
