<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 0;">Upit za {{ $i['house'] }}</h2>
    <p style="color: #666; margin-top: 4px;">Online rezervacije su isključene — gost šalje upit za odabrane datume. Rezervacija nije kreirana.</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
        <tr><td style="padding: 6px 0; color: #666; width: 160px;">Kućica</td><td style="padding: 6px 0;"><strong>{{ $i['house'] }}</strong></td></tr>
        <tr><td style="padding: 6px 0; color: #666;">Dolazak</td><td style="padding: 6px 0;"><strong>{{ $i['check_in'] }}</strong></td></tr>
        <tr><td style="padding: 6px 0; color: #666;">Odlazak</td><td style="padding: 6px 0;"><strong>{{ $i['check_out'] }}</strong> ({{ $i['nights'] }} noćenja)</td></tr>
        <tr><td style="padding: 6px 0; color: #666;">Gosti</td><td style="padding: 6px 0;">{{ $i['adults'] }} odraslih, {{ $i['children'] }} djece, {{ $i['pets'] }} ljubimaca</td></tr>
        <tr><td style="padding: 6px 0; color: #666;">Ime i prezime</td><td style="padding: 6px 0;"><strong>{{ $i['name'] }}</strong></td></tr>
        <tr><td style="padding: 6px 0; color: #666;">Email</td><td style="padding: 6px 0;"><a href="mailto:{{ $i['email'] }}">{{ $i['email'] }}</a></td></tr>
        <tr><td style="padding: 6px 0; color: #666;">Telefon</td><td style="padding: 6px 0;">{{ $i['phone'] !== '' ? $i['phone'] : '—' }}</td></tr>
        <tr><td style="padding: 6px 0; color: #666;">Jezik</td><td style="padding: 6px 0;">{{ strtoupper($i['locale']) }}</td></tr>
    </table>

    @if ($i['message'] !== '')
        <p style="margin-top: 16px; color: #666;">Poruka</p>
        <p style="white-space: pre-line;">{{ $i['message'] }}</p>
    @endif
</div>
