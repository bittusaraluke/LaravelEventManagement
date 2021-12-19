<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Event Management Company</title>
</head>
<body>
	<h1>{{ $details['subject'] }}</h1>
    <p></p>
   <p>Dear Sir/Madam,</p>
   <p>I am pleased to inform you are cordially invited to the {{ $details['event_name'] }}. This event will be organized at {{$details['event_address']}} and will be held from {{ $details['event_start_date'] }} to {{ $details['event_end_date'] }}.</p>
   <p>We look forward to your presence on the event {{$details['event_name']}}</p>
    <p>Thank you</p>
    <p>{{ $details['user'] }}</p>
</body>
</html>