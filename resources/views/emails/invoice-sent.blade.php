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

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f4f4f5;
        }

        .info-label {
            color: #71717a;
            font-size: 14px;
        }

        .info-value {
            color: #18181b;
            font-weight: 600;
            font-size: 14px;
        }

        .total-box {
            background: #f0fdf4;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-top: 24px;
        }

        .total-amount {
            font-size: 32px;
            font-weight: 800;
            color: #10B981;
        }

        .btn {
            display: inline-block;
            background: #10B981;
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
            <h1>Invoice from Seeda</h1>
            <p>#{{ $invoice->invoice_number }}</p>
        </div>
        <div class="body">
            <h2>Hello {{ $invoice->client?->name ?? 'Client' }},</h2>
            <p>Please find your invoice details below. Payment is due by
                <strong>{{ $invoice->due_date?->format('F d, Y') }}</strong>.</p>

            <div style="margin-top: 24px;">
                <div class="info-row">
                    <span class="info-label">Invoice Number</span>
                    <span class="info-value">{{ $invoice->invoice_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Issue Date</span>
                    <span class="info-value">{{ $invoice->issue_date?->format('M d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Due Date</span>
                    <span class="info-value">{{ $invoice->due_date?->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="total-box">
                <p style="margin: 0; color: #71717a; font-size: 14px;">Total Amount</p>
                <p class="total-amount">€{{ number_format($invoice->total, 2) }}</p>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="btn">View Invoice</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Seeda. All rights reserved.</p>
            <p>Milan, Italy · hello@seeda.dev</p>
        </div>
    </div>
</body>

</html>