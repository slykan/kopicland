# Kopić Land — plan i program izrade

Booking sustav za 10 kućica za odmor, Marinci. Laravel 12 + Filament 3 (admin, EN) + Blade/Livewire (javni dio, HR/EN/DE), MySQL/MariaDB. Puni opseg: `Full_CMS.docx` (lokalno, gitignored).

Repo: https://github.com/slykan/kopicland
Deploy (temp): https://vps.on-click.hr/~kopicland/

## Faza 0 — Setup
- [ ] Laravel 12 skeleton (`laravel/laravel`)
- [ ] Filament 3 admin panel
- [ ] DB šema: houses, house_photos, amenities, house_amenities, pricing_rules (base/seasonal/date), extra_costs, discounts, reservations, guests, email_templates, booking_blocks
- [ ] .env, git, deploy.sh prilagođen (placko.app pattern)

## Faza 1 — Admin: kućice
- [ ] CRUD kućica (naziv, opisi, kapacitet, sobe/kreveti/kupaonice, površina, lokacija, check-in/out, pravila, SEO)
- [ ] Foto galerija (upload, redoslijed, naslovna foto, optimizacija/web format)
- [ ] Pogodnosti (Wi-Fi, klima, parking, bazen...) — admin ih sam dodaje
- [ ] Objava / privremena odjava / arhiva / redoslijed / izdvojene / kopiranje kao predložak

## Faza 2 — Admin: cijene
- [ ] Osnovna cijena po noćenju
- [ ] Sezonske cijene (raspon datuma)
- [ ] Pojedinačna cijena po datumu (prioritet nad sezonskom/osnovnom)
- [ ] Min/max noćenja, dopušteni dan dolaska/odlaska
- [ ] Dodatni troškovi (čišćenje, boravišna pristojba, os./ljubimac/krevetić/doručak...)
- [ ] Popusti (duži boravak, rana rezervacija, last-minute, promo kod, ručni)

## Faza 3 — Admin: rezervacije
- [ ] Statusi (novi zahtjev → čeka potvrdu → potvrđena / odbijena / otkazana / završena / no-show, + privremeno rezervirano, blokiran termin)
- [ ] Ručni unos rezervacije (telefon/mail/agencija), provjera preklapanja
- [ ] Centralni kalendar (10 kućica, dan/tjedan/mjesec, filter, drag/klik, premještanje uz re-check)
- [ ] Ručno blokiranje termina
- [ ] Podaci o gostu (GDPR: privola, datum prihvaćanja pravila/privatnosti)
- [ ] Email predlošci + automatski mailovi (gost: primitak/potvrda/izmjena/odbijanje/otkazivanje; admin: novi zahtjev/otkazivanje/podsjetnik)
- [ ] Nadzorna ploča (novi zahtjevi, dolasci/odlasci, zauzetost, prihod, upozorenja)

## Faza 4 — Javni dio
- [ ] Naslovna (hero, izdvojene kućice, pogodnosti, provjera dostupnosti, foto, karta, kontakt)
- [ ] Popis kućica (kartice: foto, opis, kapacitet, cijena od, dostupnost)
- [ ] Detalj kućice (galerija, kapacitet, pogodnosti, pravila, kalendar dostupnosti, cjenik, obrazac)
- [ ] Provjera dostupnosti (datumi, gosti, kućni ljubimci → filtrira slobodne kućice)
- [ ] Rezervacijski obrazac + live izračun cijene, re-check dostupnosti prije spremanja
- [ ] Privremeno zadržavanje termina (par minuta dok gost popunjava)
- [ ] Rok za automatski istek nepotvrđenog zahtjeva (npr. 24h)
- [ ] Zaštita obrasca (captcha/rate-limit)

## Faza 5 — Višejezičnost i statične stranice
- [ ] HR/EN/DE prijevodi (front), admin samo EN
- [ ] O nama, Lokacija, Kontakt, FAQ, Pravila rezervacije, Uvjeti korištenja, Privatnost, Kolačići, Aktivnosti u okolici

## Faza 6 — Izvještaji, role, dodatno
- [ ] Statistika (rezervacije/noćenja, popunjenost, prihod, prosjeci, izvor rezervacije, izvoz CSV/Excel)
- [ ] Uloge: glavni admin / djelatnik za rezervacije / urednik sadržaja
- [ ] Evidencija plaćanja, dokumenti/privici uz rezervaciju, povijest promjena (audit log)
- [ ] Backup baze i fotografija

## Faza 7 — Deploy
- [ ] deploy.sh za vps.on-click.hr/~kopicland
- [ ] SSL, provjera na temp URL-u, kasnije domena

## Čeka se od klijenta (doc, t.15)
Logotip, tekstovi, fotografije kućica, podaci/pogodnosti po kućici, pravila rezervacije, cjenik, kontakt podaci, podaci za pravne stranice, pristup domeni/serveru.

## Napomena o starom sadržaju
`oldweb/` = generički restaurant template (dish.co), tekstovi neupotrebljivi, ali adresa/mail/tel/GPS/fotke kućica jesu (vidi `Full_CMS.docx` i memoriju projekta).
