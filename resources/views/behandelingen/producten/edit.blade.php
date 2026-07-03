<x-app-layout>
    <div class="product-page">
        <div class="product-container product-container-narrow">
            @if (session('error') || $errors->has('nieuwe_verkoopprijs'))
                <div class="product-alert-error">Gegevens niet bijgewerkt</div>
            @endif

            <div class="product-breadcrumb">
                <a href="{{ route('dashboard') }}" class="product-breadcrumb-home">Home</a>
                <span class="product-breadcrumb-sep">/</span>
                <a href="{{ route('behandelingen.index') }}" class="product-breadcrumb-link">Behandelingen</a>
                <span class="product-breadcrumb-sep">/</span>
                <span class="product-breadcrumb-current">Wijzigen</span>
            </div>

            <h1 class="product-title">
                Product wijzigen
                <span class="product-title-secondary">{{ $productDetail->Naam }}</span>
            </h1>

            <div class="product-panel">
                <form method="POST" action="{{ route('behandelingen.producten.update', ['behandeling' => $behandeling->Id, 'product' => $productDetail->Id]) }}" class="product-edit-form">
                    @csrf
                    @method('PUT')

                    <div class="product-edit-grid">
                        <div>
                            <label class="product-edit-label" for="naam">Product</label>
                            <input id="naam" value="{{ $productDetail->Naam }}" class="product-edit-input" readonly>
                        </div>
                        <div>
                            <label class="product-edit-label" for="merk">Merk</label>
                            <input id="merk" value="{{ $productDetail->Merk }}" class="product-edit-input" readonly>
                        </div>
                        <div>
                            <label class="product-edit-label" for="omschrijving">Omschrijving</label>
                            <input id="omschrijving" value="{{ $productDetail->Omschrijving }}" class="product-edit-input" readonly>
                        </div>
                        <div>
                            <label class="product-edit-label" for="eancode">EAN-code</label>
                            <input id="eancode" value="{{ $productDetail->EANcode }}" class="product-edit-input" readonly>
                        </div>
                        <div>
                            <label class="product-edit-label" for="houdbaar">Houdbaarheidsdatum</label>
                            <input id="houdbaar" value="{{ \Illuminate\Support\Carbon::parse($productDetail->Houdbaarheidsdatum)->format('d-m-Y') }}" class="product-edit-input" readonly>
                        </div>
                        <div>
                            <label class="product-edit-label" for="voorraad">Aantal op voorraad</label>
                            <input id="voorraad" value="{{ (int) $productDetail->AantalOpVoorraad }}" class="product-edit-input" readonly>
                        </div>
                        <div>
                            <label class="product-edit-label" for="inkoop">Inkoopprijs</label>
                            <input id="inkoop" value="EUR {{ number_format((float) $productDetail->InkoopPrijs, 2, ',', '.') }}" class="product-edit-input" readonly>
                        </div>
                        <div>
                            <label class="product-edit-label" for="leverancier">Leverancier</label>
                            <input id="leverancier" value="{{ $productDetail->LeverancierNaam ?: '-' }}" class="product-edit-input" readonly>
                        </div>
                        <div>
                            <label class="product-edit-label" for="huidige_verkoopprijs">Huidige verkoopprijs</label>
                            <input id="huidige_verkoopprijs" value="EUR {{ number_format((float) $productDetail->VerkoopPrijs, 2, ',', '.') }}" class="product-edit-input" readonly>
                        </div>
                        <div>
                            <label class="product-edit-label" for="plaats">Plaats leverancier</label>
                            <input id="plaats" value="{{ $productDetail->LeverancierPlaats ?: '-' }}" class="product-edit-input" readonly>
                        </div>
                    </div>

                    <div class="product-edit-grid product-edit-grid-bottom">
                        <div>
                            <label class="product-edit-label" for="nieuwe_verkoopprijs">Nieuwe verkoopprijs *</label>
                            <input
                                id="nieuwe_verkoopprijs"
                                name="nieuwe_verkoopprijs"
                                value="{{ old('nieuwe_verkoopprijs', number_format((float) $productDetail->VerkoopPrijs, 2, ',', '.')) }}"
                                class="product-edit-input {{ $errors->has('nieuwe_verkoopprijs') ? 'is-invalid' : '' }}"
                                required
                            >
                            @error('nieuwe_verkoopprijs')
                                <p class="product-field-error">{{ $message }}</p>
                            @enderror
                            <p class="product-field-help">Minimaal 30 procent boven de inkoopprijs.</p>
                        </div>
                        <div>
                            <label class="product-edit-label" for="opmerking">Opmerking</label>
                            <input id="opmerking" value="{{ $productDetail->Opmerking ?: '-' }}" class="product-edit-input" readonly>
                        </div>
                    </div>

                    <p class="product-note">Velden met een * zijn verplicht.</p>

                    <div class="product-actions-right">
                        <button type="submit" class="product-btn-primary">Opslaan</button>
                        <a href="{{ route('behandelingen.producten.show', ['behandeling' => $behandeling->Id, 'product' => $productDetail->Id]) }}" class="product-btn-back">Terug</a>
                    </div>
                </form>
            </div>
        </div>

        <footer class="product-footer">
            © 2026 Kniploket Tiko - Alle rechten voorbehouden
        </footer>
    </div>
</x-app-layout>
