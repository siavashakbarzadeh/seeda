<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f4f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            margin-top: 32px;
            margin-bottom: 32px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .header {
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            padding: 32px;
            text-align: center;
        }

        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            color: rgba(255, 255, 255, 0.8);
            margin: 8px 0 0;
            font-size: 14px;
        }

        .body {
            padding: 32px;
        }

        .body h2 {
            color: #18181b;
            font-size: 20px;
            margin-top: 0;
        }

        .body p {
            color: #52525b;
            line-height: 1.6;
        }

        .reply-box {
            background: #f8fafc;
            border-left: 4px solid #3B82F6;
            border-radius: 0 8px 8px 0;
            padding: 16px 20px;
            margin: 20px 0;
        }

        .reply-box p {
            margin: 0;
            color: #334155;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            background: #3B82F6;
            color: white;
            padding: 14px 32px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 24px;
        }

        .footer {
            background: #fafafa;
            padding: 24px 32px;
            text-align: center;
            color: #a1a1aa;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>New Reply on Your Ticket</h1>
            <p>{{ $ticket->subject }}</p>
        </div>
        <div class="body">
            <h2>Hello,</h2>
            <p>A new reply has been posted on your support ticket:</p>

            <div class="reply-box">
                <p>{!! nl2br(e($replyBody)) !!}</p>
            </div>

            <p style="font-size: 14px; color: #71717a;">
                Ticket #{{ $ticket->id }} · Status:
                <strong
                    style="color: {{ $ticket->status === 'open' ? '#10B981' : '#EAB308' }};">{{ ucfirst($ticket->status) }}</strong>
            </p>

            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="btn">View Ticket</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Seeda. All rights reserved.</p>
        </div>
    </div>
</body>

</html>