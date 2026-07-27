<x-filament-panels::page>
    <style>
        .kl-guide {
            --kg-text: #2a2f1d;
            --kg-dim: #5b6249;
            --kg-heading: #3e4a28;
            --kg-accent: #6f8140;
            --kg-rule: #dde2c9;
            --kg-code-bg: #ecefdd;
            color: var(--kg-text);
            line-height: 1.55;
        }
        .dark .kl-guide {
            --kg-text: #e7e9db;
            --kg-dim: #a9af95;
            --kg-heading: #d3dcb4;
            --kg-accent: #a8bd6f;
            --kg-rule: #3a4029;
            --kg-code-bg: #2a2f1d;
        }
        .kl-guide h2 {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--kg-accent);
            margin: 0 0 0.15rem;
        }
        .kl-guide h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--kg-heading);
            margin: 1.3rem 0 0.5rem;
        }
        .kl-guide h3:first-of-type { margin-top: 0.6rem; }
        .kl-guide .kg-path {
            display: inline-block;
            font-family: ui-monospace, "SFMono-Regular", Menlo, monospace;
            font-size: 0.82rem;
            color: var(--kg-dim);
            background: var(--kg-code-bg);
            padding: 0.1rem 0.45rem;
            border-radius: 4px;
        }
        .kl-guide ul {
            margin: 0.4rem 0 0;
            padding-left: 1.1rem;
        }
        .kl-guide li { margin: 0.3rem 0; }
        .kl-guide li::marker { color: var(--kg-accent); }
        .kl-guide li b { color: var(--kg-heading); font-weight: 650; }
        .kl-guide hr {
            border: none;
            border-top: 1px solid var(--kg-rule);
            margin: 2rem 0;
        }
        .kl-guide .kg-note {
            margin-top: 1.5rem;
            padding: 0.65rem 0.85rem;
            background: var(--kg-code-bg);
            border-left: 3px solid var(--kg-accent);
            border-radius: 0 6px 6px 0;
            font-size: 0.9rem;
            color: var(--kg-dim);
        }
    </style>

    <div class="kl-guide">
        <p style="color: var(--kg-dim); margin-top: 0;">Kratak podsjetnik što je gdje u adminu i kamo dodavati nove stvari.</p>

        <section>
            <h2>Kućice</h2>
            <h3>Houses</h3>
            <ul>
                <li>Ovdje dodaješ/uređuješ svaku kućicu — naziv, opis, kapacitet, broj soba/kreveta/kupaonica, check-in/out vrijeme, pravila.</li>
                <li>Sve tekstualno se upisuje na sva tri jezika (HR/EN/DE) — gore u formi prebacuješ jezik.</li>
                <li>Unutar svake kućice (dolje na stranici) nalaze se tri dodatne kartice:
                    <ul>
                        <li><b>Photos</b> — galerija fotki te kućice, redoslijed i naslovna foto.</li>
                        <li><b>Stay Rules</b> — min/max broj noćenja, dopušteni dani dolaska/odlaska.</li>
                        <li><b>Pricing Rules</b> — sezonske ili cijene za točan datum (nadjačavaju osnovnu cijenu).</li>
                    </ul>
                </li>
            </ul>

            <h3>Amenities</h3>
            <ul>
                <li>Popis pogodnosti (Wi-Fi, parking, klima...) koje se onda kvačicama dodjeljuju pojedinoj kućici u Houses.</li>
                <li>Polje <b>icon</b> — naziv ikone iz Tabler Icons seta (npr. <span class="kg-path">wifi</span>, <span class="kg-path">parking</span>) — prikazuje se na javnoj stranici uz pogodnost.</li>
            </ul>
        </section>

        <hr>

        <section>
            <h2>Cijene</h2>
            <h3>Guest Pricing</h3>
            <ul>
                <li>Cijena po noćenju ovisno o <b>ukupnom broju gostiju</b> (npr. 90 € za 1-2 osobe, 105 € za 3...).</li>
                <li>Ista tablica vrijedi za sve kućice. Ako gost odabere više gostiju nego što piše u najvišem redu, rezervacija se odbija.</li>
            </ul>

            <h3>Extra Costs</h3>
            <ul>
                <li>Dodatni troškovi — turistička pristojba, čišćenje i sl. Jednokratno, po noćenju, po osobi ili po osobi/noćenju.</li>
                <li>Možeš vezati uz jednu kućicu ili ostaviti prazno da vrijedi za sve.</li>
            </ul>

            <h3>Discounts</h3>
            <ul>
                <li>Popusti — dulji boravak, rana rezervacija, last-minute ili promo kod. Postotak ili fiksni iznos.</li>
            </ul>
        </section>

        <hr>

        <section>
            <h2>Rezervacije</h2>
            <h3>Reservations</h3>
            <ul>
                <li>Sve rezervacije — ručni unos (telefon/mail) ili one koje stignu s javne stranice.</li>
                <li>Status: novi zahtjev → čeka potvrdu → potvrđena / odbijena / otkazana / završena.</li>
                <li>Promjena statusa automatski šalje mail gostu na jeziku koji je gost odabrao.</li>
            </ul>

            <h3>Guests</h3>
            <ul>
                <li>Podaci o gostima (kontakt, jezik, GDPR privole) — povezani su s rezervacijama.</li>
            </ul>

            <h3>Email Templates</h3>
            <ul>
                <li>Tekstovi mailova koji se automatski šalju gostu/adminu kod promjene statusa rezervacije.</li>
                <li>U tekstu možeš koristiti <span class="kg-path">@{{house_name}}</span>, <span class="kg-path">@{{guest_name}}</span>, <span class="kg-path">@{{check_in}}</span> itd. — zamjenjuju se stvarnim podacima.</li>
            </ul>

            <h3>Calendar</h3>
            <ul>
                <li>Pregled svih rezervacija po kućicama u kalendaru — klikom na prazan termin otvara se nova rezervacija, klikom na postojeću je uređuješ.</li>
            </ul>
        </section>

        <div class="kg-note">Dashboard (početna stranica admina) prikazuje brzi pregled: novi zahtjevi, rezervacije koje čekaju potvrdu, dolasci/odlasci u sljedećih 7 dana.</div>
    </div>
</x-filament-panels::page>
