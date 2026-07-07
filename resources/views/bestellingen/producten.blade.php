<x-app-layout>
    <main class="product-page">
        <div class="product-container">
            <div class="product-breadcrumb">
                <a href="{{ route('dashboard') }}" class="product-breadcrumb-home">Home</a>
                <span class="product-breadcrumb-sep">/</span>
                <a href="{{ route('bestellingen.index') }}" class="product-breadcrumb-link">Bestellingen</a>
                <span class="product-breadcrumb-sep">/</span>
                <span class="product-breadcrumb-current">Detail</span>
            </div>

            <h1 class="product-title">
                Producten per bestelling
                <span class="product-title-secondary">{{ $bestelling->BestelNummer }}</span>
            </h1>

            {{-- Terugkoppeling aan eindgebruiker na succesvol wijzigen --}}
            @if (session('success'))
                <div class="product-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Terugkoppeling aan eindgebruiker bij fout --}}
            @if (session('error'))
                <div class="product-alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <section class="product-panel">
                @if ($producten->isEmpty())
                    <div class="product-empty">
                        Er zijn geen producten gevonden.
                    </div>
                @else
                    <div class="product-table-wrap">
                        <table class="product-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Categorie</th>
                                    <th>Merk</th>
                                    <th>Aantal</th>
                                    <th>Prijs per stuk</th>
                                    <th>BTW</th>
                                    <th>Korting</th>
                                    <th>Totaal (Kort. + BTW)</th>
                                    <th>Actie</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($producten as $product)
                                    <tr>
                                        <td>{{ $product->ProductNaam }}</td>
                                        <td>{{ $product->CategorieNaam }}</td>
                                        <td>{{ $product->Merk }}</td>
                                        <td>{{ $product->Aantal }}</td>
                                        <td>EUR {{ number_format($product->UnitPrijs, 2, ',', '.') }}</td>
                                        <td>{{ number_format($product->BTWPercentage, 2, ',', '.') }}%</td>
                                        <td>{{ number_format($product->Korting, 2, ',', '.') }}%</td>
                                        <td>EUR {{ number_format($product->TotaalBedrag, 2, ',', '.') }}</td>
                                        <td>
                                            <a
                                                href="{{ route('bestellingen.producten.edit', [$bestelling->Id, $product->Id]) }}"
                                                class="product-btn-primary"
                                            >
                                                Wijzigen
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Terugknop wordt onder de actie-kolom geplaatst zoals in het wireframe --}}
                    <div class="product-back-row">
                        <div class="product-back-column">
                            <a href="{{ route('bestellingen.index') }}" class="product-btn-back">
                                Terug
                            </a>
                        </div>
                    </div>
                @endif
            </section>

            <footer class="product-footer">
                © 2026 Kniploket Tiko - Alle rechten voorbehouden
            </footer>
        </div>
    </main>
</x-app-layout>