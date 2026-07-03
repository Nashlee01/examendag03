<x-app-layout>
    <div class="product-page">
        <div class="product-container">
            <div class="product-breadcrumb">
                <a href="{{ route('dashboard') }}" class="product-breadcrumb-home">Home</a>
                <span class="product-breadcrumb-sep">/</span>
                <a href="{{ route('behandelingen.index') }}" class="product-breadcrumb-link">Behandelingen</a>
                <span class="product-breadcrumb-sep">/</span>
                <span class="product-breadcrumb-current">Detail</span>
            </div>

            <h1 class="product-title">
                Producten per behandeling
                <span class="product-title-secondary">{{ $behandeling->Naam }}</span>
            </h1>

            <div class="product-panel">
                <div class="product-table-wrap">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Merk</th>
                                <th>Omschrijving</th>
                                <th>EAN-code</th>
                                <th>Aantal op voorraad</th>
                                <th>Verkoopprijs</th>
                                <th>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($producten as $product)
                                <tr>
                                    <td>{{ $product->Naam }}</td>
                                    <td>{{ $product->Merk }}</td>
                                    <td>{{ $product->Omschrijving }}</td>
                                    <td>{{ $product->EANcode }}</td>
                                    <td>{{ (int) $product->AantalOpVoorraad }}</td>
                                    <td>EUR {{ number_format((float) $product->VerkoopPrijs, 2, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('behandelingen.producten.show', ['behandeling' => $behandeling->Id, 'product' => $product->Id]) }}" class="product-btn-detail">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="product-empty">Geen producten gevonden voor deze behandeling.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="product-actions-right">
                    <a href="{{ route('behandelingen.index') }}" class="product-btn-back">Terug</a>
                </div>
            </div>
        </div>

        <footer class="product-footer">
            © 2026 Kniploket Tiko - Alle rechten voorbehouden
        </footer>
    </div>
</x-app-layout>
