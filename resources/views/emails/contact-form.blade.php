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
            background: linear-gradient(135deg, #10B981, #059669);
            padding: 32px;
            text-align: center;
        }

        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
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

        .info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .info-card .row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-card .row:last-child {
            border-bottom: none;
        }

        .info-card .label {
            color: #71717a;
            font-size: 13px;
        }

        .info-card .value {
            color: #18181b;
            font-weight: 600;
            font-size: 13px;
        }

        .message-box {
            background: #f0fdf4;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .message-box p {
            margin: 0;
            color: #334155;
            font-size: 14px;
            white-space: pre-wrap;
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
            <h1>📬 New Contact Form Submission</h1>
        </div>
        <div class="body">
            <h2>New message received!</h2>

            <div class="info-card">
                <div class="row">
                    <span class="label">Name</span>
                    <span class="value">{{ $contactMessage->name }}</span>
                </div>
                <div class="row">
                    <span class="label">Email</span>
                    <span class="value">{{ $contactMessage->email }}</span>
                </div>
                @if($contactMessage->company)
                    <div class="row">
                        <span class="label">Company</span>
                        <span class="value">{{ $contactMessage->company }}</span>
                    </div>
                @endif
                <div class="row">
                    <span class="label">Submitted</span>
                    <span class="value">{{ $contactMessage->created_at?->format('M d, Y H:i') }}</span>
                </div>
            </div>

            <h3 style="color: #18181b; font-size: 16px;">Message:</h3>
            <div class="message-box">
                <p>{{ $contactMessage->message }}</p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Seeda. All rights reserved.</p>
        </div>
    </div>
</body>

</html>