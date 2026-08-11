<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        body, table, td { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; width: 100% !important; background-color: #eceee2; }

        .email-body p { margin: 0 0 16px; }
        .email-body p:last-child { margin-bottom: 0; }
        .email-body h1, .email-body h2, .email-body h3 {
            margin: 24px 0 12px;
            color: #383f24;
            font-family: Georgia, 'Times New Roman', serif;
            line-height: 1.3;
        }
        .email-body h1:first-child, .email-body h2:first-child, .email-body h3:first-child { margin-top: 0; }
        .email-body h1 { font-size: 22px; }
        .email-body h2 { font-size: 19px; }
        .email-body h3 { font-size: 17px; }
        .email-body a { color: #566432; text-decoration: underline; }
        .email-body strong { color: #313721; }
        .email-body ul, .email-body ol { margin: 0 0 16px; padding-left: 22px; }
        .email-body li { margin-bottom: 6px; }
        .email-body blockquote {
            margin: 16px 0;
            padding: 4px 16px;
            border-left: 3px solid #adb97b;
            color: #566432;
            font-style: italic;
        }
        .email-body hr { border: none; border-top: 1px solid #e6e9d3; margin: 24px 0; }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#eceee2;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eceee2;">
        <tr>
            <td align="center" style="padding: 32px 16px;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:600px; background-color:#ffffff; border-radius:8px; overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td align="center" style="background-color:#ffffff; padding: 28px 24px 20px;">
                            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" width="64" height="64" style="display:block; width:64px; height:64px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#566432; height:4px; line-height:4px; font-size:0;">&nbsp;</td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 32px 36px;">
                            <div class="email-body" style="font-family: 'Instrument Sans', Arial, Helvetica, sans-serif; font-size:15px; line-height:1.6; color:#383f24;">
                                @php
                                    $__qrMarker = '{{' . 'payment_qr' . '}}';
                                    $__finalBody = $renderedBody;

                                    if ($paymentQrPng && str_contains($__finalBody, $__qrMarker)) {
                                        $__qrTag = '<img src="'.$message->embedData($paymentQrPng, 'placanje-kod.png', 'image/png').'" alt="Kod za placanje" width="220" style="display:block; width:220px; max-width:100%; height:auto; border:1px solid #e6e9d3; border-radius:4px;">';
                                        $__finalBody = str_replace($__qrMarker, $__qrTag, $__finalBody);
                                    }
                                @endphp
                                {!! $__finalBody !!}
                            </div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#313721; padding: 24px 36px; font-family: Arial, Helvetica, sans-serif;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="color:#ced5ab; font-size:13px; line-height:1.6; vertical-align:top;">
                                        <strong style="color:#ffffff;">KOPEX d.o.o.</strong><br>
                                        Hrvatske slobode 54<br>
                                        32221 Marinci<br>
                                        OIB: 73529336898<br>
                                        OTP banka<br>
                                        IBAN: HR4824070001100775365
                                    </td>
                                    <td align="right" style="color:#ced5ab; font-size:13px; line-height:1.6; vertical-align:top;">
                                        Mob: <a href="tel:+385981776674" style="color:#e6e9d3; text-decoration:none;">+385 98 177 66 74</a><br>
                                        Email: <a href="mailto:info@kopicland.hr" style="color:#e6e9d3; text-decoration:none;">info@kopicland.hr</a><br>
                                        <a href="https://kopicland.hr" style="color:#e6e9d3; text-decoration:none;">kopicland.hr</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
