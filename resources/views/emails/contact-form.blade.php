<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2563eb;
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: 600;
            color: #555;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .field-value {
            background-color: #f9fafb;
            padding: 12px;
            border-radius: 4px;
            border-left: 3px solid #2563eb;
        }
        .message-content {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 4px;
            border-left: 3px solid #2563eb;
            white-space: pre-wrap;
            min-height: 60px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        .timestamp {
            color: #9ca3af;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>📧 New Contact Form Submission</h1>

        <div class="field">
            <div class="field-label">Name</div>
            <div class="field-value">{{ $data['customer_name'] }}</div>
        </div>

        @if(!empty($data['company_name']))
        <div class="field">
            <div class="field-label">Company</div>
            <div class="field-value">{{ $data['company_name'] }}</div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Email Address</div>
            <div class="field-value">
                <a href="mailto:{{ $data['email'] }}" style="color: #2563eb; text-decoration: none;">
                    {{ $data['email'] }}
                </a>
            </div>
        </div>

        <div class="field">
            <div class="field-label">Inquiry Type</div>
            <div class="field-value">{{ $data['inquiry'] }}</div>
        </div>

        @if(!empty($data['message']))
        <div class="field">
            <div class="field-label">Message</div>
            <div class="message-content">{{ $data['message'] }}</div>
        </div>
        @endif

        <div class="footer">
            <p class="timestamp">
                Submitted on {{ now()->format('F j, Y \a\t g:i A') }} ({{ now()->timezone->getName() }})
            </p>
            <p>
                This is an automated email from your portfolio contact form.
            </p>
        </div>
    </div>
</body>
</html>
