<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 0;">{{ $subjectLine }}</h2>
    <p style="color: #666; margin-top: 4px;">Nova poruka s kontakt forme — {{ config('site.name') }}</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
        <tr>
            <td style="padding: 6px 0; color: #666; width: 160px;">Ime i prezime</td>
            <td style="padding: 6px 0;"><strong>{{ $senderName }}</strong></td>
        </tr>
        <tr>
            <td style="padding: 6px 0; color: #666;">Email</td>
            <td style="padding: 6px 0;"><a href="mailto:{{ $senderEmail }}">{{ $senderEmail }}</a></td>
        </tr>
        <tr>
            <td style="padding: 6px 0; color: #666;">Broj sudionika</td>
            <td style="padding: 6px 0;">{{ $participants }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; color: #666;">Datum</td>
            <td style="padding: 6px 0;">{{ $eventDate }}</td>
        </tr>
    </table>

    <p style="margin-top: 16px; color: #666;">Poruka</p>
    <p style="white-space: pre-line;">{{ $messageBody }}</p>
</div>
