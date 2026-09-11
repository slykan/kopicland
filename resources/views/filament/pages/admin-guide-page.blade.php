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
                <li>Kućica <b>nema</b> vlastito polje za cijenu — osnovna cijena je ista za sve kućice i dolazi iz <b>Default Pricing</b> (vidi Cijene niže), po noćenju (bez obzira na broj gostiju).</li>
                <li>Unutar svake kućice (dolje na stranici) nalaze se tri dodatne kartice:
                    <ul>
                        <li><b>Photos</b> — galerija fotki te kućice, redoslijed i naslovna foto.</li>
                        <li><b>Stay Rules</b> — min/max broj noćenja, dopušteni dani dolaska/odlaska.</li>
                        <li><b>Pricing Rules</b> — sezonske ili cijene za točan datum, samo za tu kućicu (nadjačavaju osnovnu cijenu). Za brže postavljanje za više kućica odjednom koristi <b>Set Prices</b> (vidi Cijene niže).</li>
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
            <h3>Default Pricing</h3>
            <ul>
                <li>Jedna <b>zajednička zadana cijena po noćenju</b> koja vrijedi za sve kućice i sve datume koji nemaju vlastito postavljenu cijenu niže. Ne ovisi o broju gostiju.</li>
                <li>Ako gost odabere više gostiju nego što kućica prima (kapacitet postavljen na kućici), rezervacija se odbija — ali cijena po noćenju ostaje ista bez obzira koliko gostiju dolazi.</li>
                <li>Na javnoj stranici (popis kućica) svaka kućica prikazuje raspon "od X € do Y €" — to je raspon između ove zadane cijene i eventualnih sezonskih/datumskih cijena postavljenih za tu kućicu.</li>
            </ul>

            <h3>Set Prices</h3>
            <ul>
                <li>Brzo mijenjanje cijene za jednu ili više kućica odjednom, za odabrani raspon datuma (npr. cijela sezona) — odabereš kućice, upišeš datume "od-do" i cijenu po noćenju, po želji dodaš oznaku (npr. "Visoka sezona"), pa klikneš "Set price for selected dates".</li>
                <li>Ta cijena nadjačava zadanu (Default Pricing) cijenu za odabrane kućice i datume. Ako ponovno postaviš cijenu za iste ili djelomično preklapajuće datume na istoj kućici, stara se briše i vrijedi nova — pazi da uvijek postaviš cijeli raspon koji želiš, ne samo dio koji mijenjaš.</li>
                <li>Isto se može napraviti i pojedinačno, samo za jednu kućicu, kroz karticu <b>Pricing Rules</b> na toj kućici (vidi Kućice gore).</li>
                <li>Ispod forme je tablica <b>Recently set prices</b> — pregled svega što je trenutno postavljeno (kućice, datumi, cijena, oznaka, kad je postavljeno).</li>
            </ul>

            <h3>Extra Costs</h3>
            <ul>
                <li>Dodatni troškovi — turistička pristojba, čišćenje, doručak i sl. Jednokratno, po noćenju, po osobi ili po osobi/noćenju.</li>
                <li>Možeš vezati uz jednu kućicu ili ostaviti prazno da vrijedi za sve.</li>
                <li>Kvačica <b>Optional</b> — ako je isključena (default), trošak se automatski uračuna u svaku rezervaciju za tu kućicu. Ako je uključena, gost ga vidi kao dodatnu opciju s kvačicom na formi za rezervaciju (npr. "Doručak — 10 €") i cijena se računa samo ako ju sam odabere.</li>
                <li>Na rezervaciji (Reservations → uredi) polje <b>Included extras</b> pokazuje koji su dodatni troškovi (uključujući opcionalne koje je gost odabrao) uračunati u tu rezervaciju.</li>
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
                <li>Promjena statusa automatski šalje mail gostu, na jeziku koji je gost odabrao (osim kod statusa gdje je niže navedeno da mail ne ide).</li>
                <li>Svaka rezervacija ima svoj <b>ID</b> (prvi stupac u listi) — taj broj se automatski dodaje na početak naslova svakog maila (npr. "#12 - Vaša rezervacija je potvrđena"), da ju lakše prepoznaš u inboxu.</li>
            </ul>

            <p style="margin: 0.9rem 0 0.3rem;"><b>Statusi i što svaki radi:</b></p>
            <ul>
                <li><b>New request</b> — nova rezervacija s javne stranice (ili ručno unesena s ovim statusom). Gost dobiva mail "Zaprimili smo vaš upit", a admin dobiva mail "Novi upit za rezervaciju".</li>
                <li><b>Pending confirmation</b> — gost dobiva mail s uputama za plaćanje: IBAN, opis plaćanja ("Rezervacija #ID") i QR kod za skeniranje u mobilnom bankarstvu. Kod je jedinstven za svaku rezervaciju (sadrži točan iznos, ime i adresu gosta te broj rezervacije).</li>
                <li><b>Confirmed</b> — gost dobiva mail s potvrdom rezervacije. Ako se poslije, dok je rezervacija već potvrđena, promijene datumi dolaska/odlaska, gost dobiva dodatni mail o izmjeni.</li>
                <li><b>Rejected</b> — gost dobiva mail da nažalost ne možemo prihvatiti upit.</li>
                <li><b>Cancelled</b> — gost dobiva mail o otkazivanju, a admin dobiva internu obavijest da je rezervacija otkazana.</li>
                <li><b>Completed, No show, Temporary hold, Blocked</b> — samo interne oznake za tvoju evidenciju, gost ne dobiva mail.</li>
            </ul>

            <h3>Guests</h3>
            <ul>
                <li>Podaci o gostima (kontakt, jezik, GDPR privole) — povezani su s rezervacijama.</li>
            </ul>

            <h3>Email Templates</h3>
            <ul>
                <li>Tekstovi mailova iz tablice statusa gore — svaki predložak uređuješ posebno na sva tri jezika (gore u formi prebacuješ jezik).</li>
                <li>U tekstu možeš koristiti <span class="kg-path">@{{house_name}}</span>, <span class="kg-path">@{{guest_name}}</span>, <span class="kg-path">@{{check_in}}</span>, <span class="kg-path">@{{check_out}}</span>, <span class="kg-path">@{{reservation_id}}</span>, <span class="kg-path">@{{total_price}}</span> — zamjenjuju se stvarnim podacima.</li>
                <li>U predlošku <b>Pending confirmation</b> (guest_pending) nemoj brisati oznaku <span class="kg-path">@{{payment_qr}}</span> — na tom mjestu se u mailu ubacuje slika QR koda za plaćanje.</li>
            </ul>

            <h3>Calendar</h3>
            <ul>
                <li>Pregled svih rezervacija po kućicama u kalendaru — klikom na prazan termin otvara se nova rezervacija, klikom na postojeću je uređuješ.</li>
            </ul>

            <h3>Block Dates</h3>
            <ul>
                <li>Brzo zauzimanje termina za jednu ili više kućica odjednom (npr. za renovaciju, vlastiti boravak i sl.) — odabereš kućice, upišeš datume i po želji internu napomenu, pa klikneš "Block selected dates".</li>
                <li>Za svaku odabranu kućicu se kreira zasebna rezervacija sa statusom <b>Blocked</b> (bez gosta, gost ne dobiva mail). Ako je neka kućica za odabrane datume već zauzeta/blokirana, ta se kućica preskoči (dobiješ obavijest koja je), a ostale se ipak blokiraju.</li>
                <li>Blokirani termini se poslije mogu urediti ili obrisati kao i svaka druga rezervacija, u listi Reservations.</li>
                <li>Ispod forme je tablica <b>Currently blocked</b> — pregled svega što je trenutno blokirano (kućice, datumi, razlog, kad je postavljeno).</li>
            </ul>
        </section>

        <div class="kg-note">Dashboard (početna stranica admina) prikazuje brzi pregled: novi zahtjevi, rezervacije koje čekaju potvrdu, dolasci/odlasci u sljedećih 7 dana.</div>
    </div>
</x-filament-panels::page>
