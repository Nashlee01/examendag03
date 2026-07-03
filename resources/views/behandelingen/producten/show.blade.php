<x-app-layout>
    <div class="product-page">
        <div class="product-container product-container-narrow">
            @if (session('status_product'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="product-alert-success">
                    {{ session('status_product') }}
                </div>
            @endif

            <div class="product-breadcrumb">
                <a href="{{ route('dashboard') }}" class="product-breadcrumb-home">Home</a>
                <span class="product-breadcrumb-sep">/</span>
                <a href="{{ route('behandelingen.index') }}" class="product-breadcrumb-link">Behandelingen</a>
                <span class="product-breadcrumb-sep">/</span>
                <span class="product-breadcrumb-current">Detail</span>
            </div>

            <h1 class="product-title">
                Productdetail
                <span class="product-title-secondary">{{ $productDetail->Naam }}</span>
            </h1>

            <div class="product-panel">
                <table class="product-detail-table">
                    <tbody>
                        <tr><th>Product</th><td>{{ $productDetail->Naam }}</td></tr>
                        <tr><th>Merk</th><td>{{ $productDetail->Merk }}</td></tr>
                        <tr><th>Omschrijving</th><td>{{ $productDetail->Omschrijving }}</td></tr>
                        <tr><th>EAN-code</th><td>{{ $productDetail->EANcode }}</td></tr>
                        <tr><th>Houdbaarheidsdatum</th><td>{{ \Illuminate\Support\Carbon::parse($productDetail->Houdbaarheidsdatum)->format('d m Y') }}</td></tr>
                        <tr><th>Inkoopprijs</th><td>EUR {{ number_format((float) $productDetail->InkoopPrijs, 2, ',', '.') }}</td></tr>
                        <tr><th>Verkoopprijs</th><td>EUR {{ number_format((float) $productDetail->VerkoopPrijs, 2, ',', '.') }}</td></tr>
                        <tr><th>Aantal op voorraad</th><td>{{ (int) $productDetail->AantalOpVoorraad }}</td></tr>
                        <tr><th>Leverancier</th><td>{{ $productDetail->LeverancierNaam ?: '-' }}</td></tr>
                        <tr><th>Postcode leverancier</th><td>{{ $productDetail->LeverancierPostcode ?: '-' }}</td></tr>
                        <tr><th>Plaats leverancier</th><td>{{ $productDetail->LeverancierPlaats ?: '-' }}</td></tr>
                        <tr><th>E-mail leverancier</th><td>{{ $productDetail->LeverancierEmail ?: '-' }}</td></tr>
                        <tr><th>Mobiel leverancier</th><td>{{ $productDetail->LeverancierMobiel ?: '-' }}</td></tr>
                        <tr><th>Opmerking</th><td>{{ $productDetail->Opmerking ?: '-' }}</td></tr>
                    </tbody>
                </table>

                <div class="product-actions-right">
                    <a href="{{ route('behandelingen.producten.edit', ['behandeling' => $behandeling->Id, 'product' => $productDetail->Id]) }}" class="product-btn-primary">Wijzigen</a>
                    <a href="{{ route('behandelingen.producten.index', ['behandeling' => $behandeling->Id]) }}" class="product-btn-back">Terug</a>
                </div>
            </div>
        </div>

        <footer class="product-footer">
            © 2026 Kniploket Tiko - Alle rechten voorbehouden
        </footer>
    </div>
</x-app-layout>
