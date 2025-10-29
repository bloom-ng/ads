<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Qualified Lead</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 30px -30px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .badge {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }

        .info-item {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }

        .info-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 16px;
            color: #111827;
            font-weight: 500;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .cta-button {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
        }

        .cta-button:hover {
            background-color: #5568d3;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }

        .alert {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px 16px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .alert-title {
            font-weight: 600;
            color: #92400e;
            margin-bottom: 4px;
        }

        .alert-text {
            color: #78350f;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🎉 New Qualified Lead</h1>
            <span class="badge">{{ $lead->tag }}</span>
        </div>

        <div class="alert">
            <div class="alert-title">⚡ Action Required</div>
            <div class="alert-text">Please assign to the appropriate department for follow-up within 24 hours.</div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">👤 Client Name</div>
                <div class="info-value">{{ $lead->client_name }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">🏢 Business Name</div>
                <div class="info-value">{{ $lead->brand_name }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">🏭 Industry</div>
                <div class="info-value">{{ $industry_name }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">💰 Budget Range</div>
                <div class="info-value">{{ $budget_range }}</div>
            </div>

            <div class="info-item full-width">
                <div class="info-label">📦 Services Interested In</div>
                <div class="info-value">{{ $services_text }}</div>
            </div>

            <div class="info-item full-width">
                <div class="info-label">🎯 Goals (Next 3-6 months)</div>
                <div class="info-value">{{ $lead->goals }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">⏰ Timeline</div>
                <div class="info-value">{{ $timeline }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">📞 Preferred Contact Method</div>
                <div class="info-value">{{ $contact_method }}</div>
            </div>

            @if ($lead->phone_number)
                <div class="info-item">
                    <div class="info-label">📱 Phone Number</div>
                    <div class="info-value">{{ $lead->phone_number }}</div>
                </div>
            @endif

            <div class="info-item">
                <div class="info-label">📅 Submitted</div>
                <div class="info-value">{{ $lead->created_at->format('M d, Y - h:i A') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">🆔 Lead ID</div>
                <div class="info-value">#{{ $lead->id }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">🏷️ Status</div>
                <div class="info-value">{{ ucfirst($lead->status) }}</div>
            </div>
        </div>

        @if (config('app.url'))
            <a href="{{ config('app.url') }}/admin/leads/{{ $lead->id }}" class="cta-button">
                View Full Lead Details →
            </a>
        @endif

        <div class="footer">
            <p><strong>Bloom Digital Media Ltd.</strong><br>
                Premium Marketing, Media & Technology Company</p>
            <p style="font-size: 12px; color: #9ca3af;">
                This is an automated notification from the Bloom WhatsApp Flow system.<br>
                Lead Token: {{ $lead->flow_token }}
            </p>
        </div>
    </div>
</body>

</html>
