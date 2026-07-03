<x-app-layout>
    <div class="behandeling-page">
        <div class="behandeling-container">
            <div class="behandeling-breadcrumb">
                <a href="{{ route('dashboard') }}" class="behandeling-breadcrumb-home">Home</a>
                <span class="behandeling-breadcrumb-sep">/</span>
                <span class="behandeling-breadcrumb-current">Behandelingen</span>
            </div>

            <h1 class="behandeling-title">Overzicht behandelingen</h1>

            @if (! empty($dbMelding))
                <div class="behandeling-alert-warning">
                    {{ $dbMelding }}
                </div>
            @endif

            <div class="behandeling-panel">
                <form method="GET" action="{{ route('behandelingen.index') }}" class="behandeling-filter-form">
                    <div class="behandeling-filter-field">
                        <label for="behandeling" class="behandeling-filter-label">Behandeling selecteren</label>
                        <select
                            name="behandeling"
                            id="behandeling"
                            class="behandeling-filter-select"
                        >
                            @foreach ($behandelingOpties as $optie)
                                <option value="{{ $optie }}" @selected($geselecteerdeBehandeling === $optie)>{{ $optie }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="behandeling-btn-primary">
                        Maak selectie
                    </button>

                    <a href="{{ route('behandelingen.index') }}" class="behandeling-btn-reset">
                        Reset
                    </a>
                </form>
            </div>

            <div class="behandeling-panel">
                <div class="behandeling-counter">
                    Gevonden behandelingen - {{ $behandelingen->total() }} behandeling(en)
                </div>

                @if ($behandelingen->hasPages())
                    <div class="behandeling-pagination">
                        @if ($behandelingen->onFirstPage())
                            <span class="behandeling-pagination-item is-disabled">&lsaquo;</span>
                        @else
                            <a href="{{ $behandelingen->previousPageUrl() }}" class="behandeling-pagination-item">&lsaquo;</a>
                        @endif

                        @foreach ($behandelingen->getUrlRange(1, $behandelingen->lastPage()) as $page => $url)
                            @if ($page === $behandelingen->currentPage())
                                <span class="behandeling-pagination-item is-active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="behandeling-pagination-item">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($behandelingen->hasMorePages())
                            <a href="{{ $behandelingen->nextPageUrl() }}" class="behandeling-pagination-item">&rsaquo;</a>
                        @else
                            <span class="behandeling-pagination-item is-disabled">&rsaquo;</span>
                        @endif
                    </div>
                @endif

                <div class="behandeling-table-wrap">
                    <table class="behandeling-table">
                        <thead>
                            <tr>
                                <th>Soort</th>
                                <th>Omschrijving</th>
                                <th>Duur</th>
                                <th>Prijs</th>
                                <th>Aantal producten</th>
                                <th>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($behandelingen as $behandeling)
                                <tr>
                                    <td class="behandeling-type">{{ $behandeling->Naam }}</td>
                                    <td>{{ $behandeling->Omschrijving }}</td>
                                    <td>{{ $behandeling->Duurminuten }} min</td>
                                    <td>EUR {{ number_format((float) $behandeling->Prijs, 2, ',', '.') }}</td>
                                    <td>{{ (int) $behandeling->aantal_producten }}</td>
                                    <td>
                                        <a
                                            href="{{ route('behandelingen.producten.index', $behandeling->Id) }}"
                                            class="behandeling-action-link"
                                        >
                                            Producten
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="behandeling-empty">Er zijn geen behandelingen bekent met deze naam</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer class="behandeling-footer">
            © 2026 Kniploket Tiko - Alle rechten voorbehouden
        </footer>
    </div>
</x-app-layout>
