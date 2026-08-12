<x-layouts.app :title="__('site.footer.legal').' — '.config('site.name')">
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        <h1 class="text-3xl font-semibold text-brand-900">{{ __('site.footer.legal') }}</h1>
        <p class="mt-4 text-sm text-brand-500">{{ __('site.pages.content_pending') }}</p>

        <nav class="mt-8 flex flex-wrap gap-4 rounded-xl bg-brand-50 p-4 text-sm font-medium text-brand-700">
            <a href="#booking-rules" class="hover:text-brand-500">{{ __('site.pages.booking_rules_title') }}</a>
            <a href="#terms" class="hover:text-brand-500">{{ __('site.pages.terms_title') }}</a>
            <a href="#privacy" class="hover:text-brand-500">{{ __('site.pages.privacy_title') }}</a>
            <a href="#cookies" class="hover:text-brand-500">{{ __('site.pages.cookies_title') }}</a>
        </nav>

        <section id="booking-rules" class="mt-12 scroll-mt-24">
            <h2 class="text-xl font-semibold text-brand-900">{{ __('site.pages.booking_rules_title') }}</h2>
            <div class="mt-3 space-y-3 text-sm leading-relaxed text-brand-600">
                <p>Prijava gostiju je moguća od 15:00 sati, a odjava do 10:00 sati, osim ako nije drugačije dogovoreno s domaćinom.</p>
                <p>Rezervacija se smatra potvrđenom nakon uplate akontacije u iznosu naznačenom u potvrdi rezervacije, u roku koji je tamo naveden.</p>
                <p>Otkazivanje rezervacije moguće je besplatno do 14 dana prije dolaska; nakon toga akontacija se ne vraća.</p>
                <p>Broj gostiju ne smije prelaziti kapacitet naveden u opisu kućice. Kućni ljubimci su dopušteni samo uz prethodni dogovor.</p>
            </div>
        </section>

        <section id="terms" class="mt-12 scroll-mt-24">
            <h2 class="text-xl font-semibold text-brand-900">{{ __('site.pages.terms_title') }}</h2>
            <div class="mt-3 space-y-3 text-sm leading-relaxed text-brand-600">
                <p>Korištenjem ove web stranice prihvaćate ove uvjete korištenja u cijelosti. Ako se s njima ne slažete, molimo da ne koristite stranicu.</p>
                <p>Sadržaj stranice (opisi kućica, fotografije, cijene) informativne je prirode i podložan je promjenama bez prethodne najave.</p>
                <p>Sva prava na sadržaj stranice zadržava Kopićland, osim ako je drugačije naznačeno.</p>
            </div>
        </section>

        <section id="privacy" class="mt-12 scroll-mt-24">
            <h2 class="text-xl font-semibold text-brand-900">{{ __('site.pages.privacy_title') }}</h2>
            <div class="mt-3 space-y-3 text-sm leading-relaxed text-brand-600">
                <p>Osobne podatke koje unesete prilikom rezervacije (ime, kontakt podaci, podaci o boravku) koristimo isključivo u svrhu obrade i provedbe vaše rezervacije.</p>
                <p>Podaci se ne dijele s trećim stranama, osim kada je to nužno za izvršenje usluge (npr. prijava boravka nadležnim tijelima) ili zakonski obvezno.</p>
                <p>Podatke čuvamo onoliko dugo koliko je potrebno u skladu sa zakonskim obvezama i legitimnim interesom poslovanja. U svakom trenutku možete zatražiti uvid, ispravak ili brisanje svojih podataka.</p>
            </div>
        </section>

        <section id="cookies" class="mt-12 scroll-mt-24">
            <h2 class="text-xl font-semibold text-brand-900">{{ __('site.pages.cookies_title') }}</h2>
            <div class="mt-3 space-y-3 text-sm leading-relaxed text-brand-600">
                <p>Ova stranica koristi kolačiće (cookies) nužne za njezino ispravno funkcioniranje, uključujući pamćenje jezičnih postavki i sesije prilikom rezervacije.</p>
                <p>Ne koristimo kolačiće trećih strana u svrhu oglašavanja. Onemogućavanje kolačića u pregledniku može utjecati na ispravan rad stranice.</p>
            </div>
        </section>
    </div>
</x-layouts.app>
