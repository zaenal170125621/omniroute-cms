<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Langganan</title>
</head>
<body style="margin:0;padding:0;background:#F5F5F3;font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F5F5F3;padding:32px 16px;">
    <tr>
        <td align="center">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#FFFFFF;border-radius:8px;overflow:hidden;">
                <tr>
                    <td style="background:#0A0A0A;color:#FFFFFF;padding:20px 24px;">
                        <span style="font-size:11px;letter-spacing:2px;color:#FF4D00;font-weight:bold;">NEWSLETTER</span>
                        <h1 style="margin:6px 0 0;font-size:20px;">{{ __('Konfirmasi langganan Anda') }}</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px;">
                        <p style="font-size:14px;line-height:1.6;color:#333333;margin:0 0 16px;">
                            Halo, terima kasih sudah berlangganan update dari {{ setting('company_name', 'OmniRoute Studio') }}.
                        </p>
                        <p style="font-size:14px;line-height:1.6;color:#333333;margin:0 0 24px;">
                            Klik tombol di bawah untuk mengonfirmasi alamat email Anda:
                        </p>
                        <p style="margin:24px 0;text-align:center;">
                            <a href="{{ route('newsletter.confirm', $subscriber->confirmation_token) }}" style="display:inline-block;background:#FF4D00;color:#FFFFFF;text-decoration:none;padding:12px 28px;border-radius:4px;font-weight:bold;">{{ __('Konfirmasi Langganan') }} →</a>
                        </p>
                        <p style="font-size:12px;color:#888888;margin:24px 0 0;">
                            Jika Anda tidak mendaftar, abaikan email ini.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="background:#0A0A0A;color:#888888;font-size:11px;padding:12px 24px;text-align:center;">
                        {{ setting('company_name', 'OmniRoute Studio') }} — dikirim otomatis oleh sistem.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
