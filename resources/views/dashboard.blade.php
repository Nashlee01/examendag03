<x-app-layout>
    <div class="min-h-[calc(100vh-56px)] bg-[#e6e8ee] pt-10 flex flex-col">
        <div class="mx-auto w-full max-w-[1400px] px-4 sm:px-6 lg:px-8 flex-1">
            <div class="rounded-2xl border border-gray-300 bg-gradient-to-r from-[#f5f7fa] to-[#f7f2e7] px-10 py-11 shadow-sm">
                <span title="Dit is de Kapsalon applicatie" class="inline-block rounded-md bg-yellow-400 px-3 py-1 text-xs font-bold text-gray-800">Kapsalon applicatie</span>

                <h1 class="mt-6 text-[32px] font-extrabold tracking-tight text-slate-600">Eigenaar</h1>
                <p class="mt-2 text-[18px] font-semibold text-slate-500">Home</p>
                <p class="mt-5 max-w-[980px] text-[23px] leading-[1.35] text-gray-500">
                    Welkom bij Kniploket Tiko - hier regel je eenvoudig klanten, afspraken en planning voor de salon.
                </p>

                <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @php
                        $cards = [
                            ['title' => 'Accounts', 'text' => 'Beheer gebruikersaccounts en roltoewijzingen.', 'href' => route('dashboard')],
                            ['title' => 'Medewerkers', 'text' => 'Overzicht van medewerkers en hun basisgegevens.', 'href' => '#'],
                            ['title' => 'Beschikbaarheid', 'text' => 'Bekijk de beschikbaarheid van medewerkers per dag en tijd.', 'href' => '#'],
                            ['title' => 'Klanten', 'text' => 'Bekijk en filter klantgegevens op postcode en contactinformatie.', 'href' => '#'],
                            ['title' => 'Afspraken', 'text' => 'Plan, bekijk en beheer afspraken met status en tijd.', 'href' => '#'],
                            ['title' => 'Behandelingen', 'text' => 'Overzicht van behandelingen, duur en prijsinformatie.', 'href' => route('behandelingen.index')],
                            ['title' => 'Producten', 'text' => 'Bekijk en beheer producten binnen het assortiment.', 'href' => '#'],
                            ['title' => 'Bestellingen', 'text' => 'Bekijk en beheer klantbestellingen en bestelstatus.', 'href' => '#'],
                        ];
                    @endphp

                    @foreach ($cards as $card)
                        <article title="{{ $card['title'] }}" class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                            <h3 class="text-[18px] font-bold leading-tight text-gray-800">{{ $card['title'] }}</h3>
                            <p class="mt-2 min-h-[98px] text-[13px] leading-[1.4] text-gray-500">{{ $card['text'] }}</p>
                            <a href="{{ $card['href'] }}" title="Open {{ $card['title'] }}" class="inline-block rounded-xl border border-blue-400 px-3 py-1 text-[14px] font-semibold text-blue-600 hover:bg-blue-50">
                                Openen
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>

        <footer class="mt-6 pb-6 text-center text-sm text-gray-500">
            © 2026 Kniploket Tiko - Alle rechten voorbehouden
        </footer>
    </div>
</x-app-layout>
