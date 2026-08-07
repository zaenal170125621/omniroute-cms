<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Baru</title>
</head>
<body style="margin:0;padding:0;background:#F5F5F3;font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F5F5F3;padding:32px 16px;">
    <tr>
        <td align="center">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#FFFFFF;border-radius:8px;overflow:hidden;">
                <tr>
                    <td style="background:#0A0A0A;color:#FFFFFF;padding:20px 24px;">
                        <span style="font-size:11px;letter-spacing:2px;color:#FF4D00;font-weight:bold;">LEAD BARU</span>
                        <h1 style="margin:6px 0 0;font-size:20px;">{{ $lead->name }}</h1>
                        <span style="font-size:12px;color:#BBBBBB;">via {{ strtoupper($lead->source) }} · {{ $lead->createdLabel() }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;line-height:1.6;">
                            <tr>
                                <td style="padding:6px 0;color:#666666;width:140px;">Nama</td>
                                <td style="padding:6px 0;font-weight:bold;">{{ $lead->name }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;color:#666666;">Email</td>
                                <td style="padding:6px 0;"><a href="mailto:{{ $lead->email }}" style="color:#FF4D00;text-decoration:none;">{{ $lead->email }}</a></td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;color:#666666;">Telepon</td>
                                <td style="padding:6px 0;">{{ $lead->phone ?: '—' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;color:#666666;">Perusahaan</td>
                                <td style="padding:6px 0;">{{ $lead->company ?: '—' }}</td>
                            </tr>
                            @if ($lead->package)
                            <tr>
                                <td style="padding:6px 0;color:#666666;">Paket</td>
                                <td style="padding:6px 0;">{{ ucfirst($lead->package) }}</td>
                            </tr>
                            @endif
                            @if ($lead->service)
                            <tr>
                                <td style="padding:6px 0;color:#666666;">Layanan</td>
                                <td style="padding:6px 0;">{{ $lead->service->title }}</td>
                            </tr>
                            @endif
                            @if ($lead->budget)
                            <tr>
                                <td style="padding:6px 0;color:#666666;">Budget</td>
                                <td style="padding:6px 0;">{{ $lead->budget }}</td>
                            </tr>
                            @endif
                            @if ($lead->timeline)
                            <tr>
                                <td style="padding:6px 0;color:#666666;">Timeline</td>
                                <td style="padding:6px 0;">{{ $lead->timeline }}</td>
                            </tr>
                            @endif
                            @if ($lead->message)
                            <tr>
                                <td style="padding:6px 0;color:#666666;vertical-align:top;">Pesan</td>
                                <td style="padding:6px 0;">{{ $lead->message }}</td>
                            </tr>
                            @endif
                        </table>

                        <p style="margin:24px 0 0;text-align:center;">
                            <a href="{{ route('filament.resources.leads.edit', $lead) }}" style="display:inline-block;background:#0A0A0A;color:#FFFFFF;text-decoration:none;padding:12px 28px;border-radius:4px;font-weight:bold;">Lihat di Panel Admin →</a>
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
