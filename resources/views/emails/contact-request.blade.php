<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <title>Нове звернення на міському порталі</title>
</head>
<body style="font-family: system-ui, -apple-system, sans-serif; background-color: #f4f4f5; margin: 0; padding: 24px; color: #18181b;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 32px; border: 1px solid #e4e4e7;">
        <h2 style="margin-top: 0; color: #09090b; font-size: 20px;">Отримано нове звернення з міського порталу</h2>
        <hr style="border: none; border-top: 1px solid #e4e4e7; margin: 20px 0;">

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; color: #71717a; width: 140px; font-weight: 500;">Ім'я:</td>
                <td style="padding: 8px 0; font-weight: 600; color: #09090b;">{{ $contactRequest->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #71717a; font-weight: 500;">Email:</td>
                <td style="padding: 8px 0;"><a href="mailto:{{ $contactRequest->email }}" style="color: #2563eb;">{{ $contactRequest->email }}</a></td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #71717a; font-weight: 500;">Тема:</td>
                <td style="padding: 8px 0; font-weight: 600; color: #09090b;">{{ $contactRequest->subject_label }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #71717a; font-weight: 500;">IP адреса:</td>
                <td style="padding: 8px 0; color: #71717a;">{{ $contactRequest->ip_address ?? 'Не визначено' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #71717a; font-weight: 500;">Дата & Час:</td>
                <td style="padding: 8px 0; color: #71717a;">{{ $contactRequest->created_at->format('d.m.Y H:i') }}</td>
            </tr>
        </table>

        <div style="margin-top: 24px; padding: 16px; background-color: #f4f4f5; border-radius: 8px; border-left: 4px solid #2563eb;">
            <p style="margin: 0; font-weight: 600; color: #09090b; margin-bottom: 8px;">Повідомлення:</p>
            <p style="margin: 0; white-space: pre-line; color: #27272a; line-height: 1.6;">{{ $contactRequest->message }}</p>
        </div>

        <div style="margin-top: 32px; text-align: center; color: #a1a1aa; font-size: 13px;">
            Міський портал «All Kropyvnytskiy»
        </div>
    </div>
</body>
</html>
