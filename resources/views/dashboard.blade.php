<x-app-layout>
    <div class="dashboard-page">
        <div class="dashboard-container">
            <div class="dashboard-hero">
                <span title="Dit is de Kapsalon applicatie" class="dashboard-badge">Kapsalon applicatie</span>

                <h1 class="dashboard-title">Eigenaar</h1>
                <p class="dashboard-subtitle">Home</p>
                <p class="dashboard-intro">
                    Welkom bij Kniploket Tiko - hier regel je eenvoudig klanten, afspraken en planning voor de salon.
                </p>

                <div class="dashboard-grid">
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
                        <article title="{{ $card['title'] }}" class="dashboard-card">
                            <h3 class="dashboard-card-title">{{ $card['title'] }}</h3>
                            <p class="dashboard-card-text">{{ $card['text'] }}</p>
                            <a href="{{ $card['href'] }}" title="Open {{ $card['title'] }}" class="dashboard-card-link">
                                Openen
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>

        <footer class="dashboard-footer">
            © 2026 Kniploket Tiko - Alle rechten voorbehouden
        </footer>
    </div>
</x-app-layout>
