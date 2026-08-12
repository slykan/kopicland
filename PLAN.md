# Kopićland — plan i program izrade

Booking sustav za 10 kućica za odmor, Marinci. Laravel 12 + Filament 3 (admin, EN) + Blade/Livewire (javni dio, HR/EN/DE), MySQL/MariaDB. Puni opseg: `Full_CMS.docx` (lokalno, gitignored).

Repo: https://github.com/slykan/kopicland
Deploy (temp): https://vps.on-click.hr/~kopicland/

## Faza 0 — Setup
- [x] Laravel 12 skeleton (`laravel/laravel`)
- [x] Filament 3 admin panel
- [x] DB šema: houses, house_photos, amenities, house_amenities, pricing_rules (base/seasonal/date), extra_costs, discounts, stay_rules, reservations (+payments/documents/logs), guests, email_templates
- [ ] .env produkcija (mysql), deploy.sh prilagođen (placko.app pattern) — v idi Faza 7

## Faza 1 — Admin: kućice
- [x] CRUD kućica (naziv, opisi, kapacitet, sobe/kreveti/kupaonice, površina, lokacija, check-in/out, pravila, SEO) — translatable HR/EN/DE preko locale switchera
- [x] Foto galerija (upload, redoslijed, naslovna foto)
- [x] Pogodnosti (Wi-Fi, klima, parking, bazen...) — admin ih sam dodaje
- [x] Objava / privremena odjava / arhiva / redoslijed / izdvojene
- [ ] Kopiranje postojeće kućice kao predloška (nije napravljeno)
- [ ] Automatska optimizacija/web format fotografija (nije napravljeno)

## Faza 2 — Admin: cijene
- [x] Osnovna cijena po noćenju
- [x] Sezonske cijene (raspon datuma)
- [x] Pojedinačna cijena po datumu (prioritet nad sezonskom/osnovnom)
- [x] Min/max noćenja, dopušteni dan dolaska/odlaska
- [x] Dodatni troškovi (jednokratno/po noćenju/po osobi/po osobi i noćenju, po kućici ili globalno)
- [x] Popusti (duži boravak, rana rezervacija, last-minute, promo kod, ručni tip postoji ali ručna primjena iz admina još nije UI-rana)

## Faza 3 — Admin: rezervacije
- [x] Statusi (novi zahtjev → čeka potvrdu → potvrđena / odbijena / otkazana / završena / no-show, + privremeno rezervirano, blokiran termin)
- [x] Ručni unos rezervacije (telefon/mail/agencija), provjera preklapanja (AvailabilityChecker + HouseIsAvailable rule)
- [x] Centralni kalendar (10 kućica, mjesec/tjedan/dan, filter po kućici/statusu, premještanje uz obveznu re-provjeru dostupnosti)
- [x] Ručno blokiranje termina (status "blocked")
- [x] Podaci o gostu (GDPR: privola, datum prihvaćanja pravila/privatnosti)
- [x] Email predlošci + automatski mailovi (gost: primitak/potvrda/odbijanje/otkazivanje/izmjena; admin: novi zahtjev/otkazivanje) — na jeziku gosta
- [x] Povijest promjena (reservation_logs)
- [ ] Nadzorna ploča/dashboard widgeti (novi zahtjevi, dolasci/odlasci, zauzetost, prihod) — nije napravljeno
- [ ] Podsjetnik prije dolaska / mail nakon odlaska — predlošci postoje, automatsko slanje (scheduled) još nije ožičeno
- [ ] Rok za automatski istek nepotvrđenog zahtjeva (cron) — nije napravljeno

## Faza 4 — Javni dio
- [x] Naslovna (hero, izdvojene kućice, provjera dostupnosti)
- [x] Popis kućica (kartice: foto, opis, kapacitet, cijena od) + filter po dostupnosti/kapacitetu
- [x] Detalj kućice (galerija, kapacitet, pogodnosti, pravila, opis, booking forma)
- [x] Provjera dostupnosti (datumi, gosti → filtrira slobodne kućice)
- [x] Rezervacijski obrazac + live izračun cijene (PriceCalculator), re-check dostupnosti prije spremanja
- [ ] Kalendar dostupnosti na stranici kućice (vizualni prikaz zauzetih datuma) — nije napravljeno, trenutno samo re-check pri submitu
- [ ] Privremeno zadržavanje termina (hold) — nije napravljeno (doc označava kao "dodatna preporučena funkcija")
- [ ] Rok za automatski istek nepotvrđenog zahtjeva — nije napravljeno
- [ ] Zaštita obrasca (captcha/rate-limit) — nije napravljeno

## Faza 5 — Višejezičnost i statične stranice
- [x] HR/EN/DE rute i UI chrome (nav/footer/forme), admin samo EN (ForceEnglishLocale middleware)
- [x] Stranice postoje kao rute: O nama, Lokacija, Kontakt, FAQ, Pravila rezervacije, Uvjeti korištenja, Privatnost, Kolačići — sadržaj je placeholder dok klijent ne pošalje tekstove
- [ ] Aktivnosti u okolici / preporuke — nije napravljeno
- [ ] Stvarni prijevodi sadržaja kućica (HR uneseno, EN/DE fallback na HR dok admin ne prevede)

## Faza 6 — Izvještaji, role, dodatno
- [x] Dashboard widget (novi zahtjevi, čeka potvrdu, potvrđeno, dolasci/odlasci sljedećih 7 dana, potvrđena vrijednost)
- [x] Uloge: glavni admin / djelatnik za rezervacije / urednik sadržaja — ožičeno preko `canViewAny()`/`canAccess()` po resursu, testirano
- [x] Evidencija plaćanja (reservation_payments) i dokumenti/privici (reservation_documents) — relation manageri na ReservationResource
- [x] Povijest promjena (reservation_logs) — automatski preko ReservationObserver
- [ ] Statistika/izvještaji (popunjenost, prihod, prosjeci) i izvoz CSV/Excel — **preskočeno po dogovoru, nije prioritet za sada**
- [ ] Backup baze i fotografija — **preskočeno po dogovoru, nije prioritet za sada**

## Faza 7 — Deploy
- [x] deploy.sh za vps.on-click.hr (account `kopicland`, domena kopicland.hr već vezana na account)
- [x] Produkcija deployana (2026-07-24): composer/npm build, .env (MySQL + cPanel SMTP), migracije, admin user, cron za scheduler
- [ ] SSL (AutoSSL) — čeka DNS delegaciju
- [ ] DNS delegacija kopicland.hr na razini .hr registra — domena nije delegirana ni na jedan nameserver (nije propagacija, nego nedostaje NS zapis na registraru), korisnik provjerava kod registrara

## Čeka se od klijenta (doc, t.15)
Logotip, tekstovi, fotografije kućica, podaci/pogodnosti po kućici, pravila rezervacije, cjenik, kontakt podaci, podaci za pravne stranice, pristup domeni/serveru.

## Napomena o starom sadržaju
`oldweb/` = generički restaurant template (dish.co), tekstovi neupotrebljivi, ali adresa/mail/tel/GPS/fotke kućica jesu (vidi `Full_CMS.docx` i memoriju projekta).
