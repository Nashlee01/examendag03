<x-app-layout>
    <x-slot name="header">
        <h2 class="behandeling-edit-header">
            {{ __('Behandeling bijwerken') }}
        </h2>
    </x-slot>

    <div class="behandeling-edit-page">
        <div class="behandeling-edit-container">
            @if (session('error'))
                <div class="behandeling-edit-alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="behandeling-edit-alert">
                    <ul class="behandeling-edit-errors">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="behandeling-edit-card">
                <form method="POST" action="{{ route('behandelingen.update', $behandeling) }}" class="behandeling-edit-form">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="naam" class="behandeling-edit-label">Naam behandeling</label>
                        <input
                            id="naam"
                            name="naam"
                            type="text"
                            required
                            maxlength="100"
                            value="{{ old('naam', $behandeling->Naam) }}"
                            class="behandeling-edit-input"
                        >
                    </div>

                    <div>
                        <label for="omschrijving" class="behandeling-edit-label">Omschrijving</label>
                        <textarea
                            id="omschrijving"
                            name="omschrijving"
                            required
                            maxlength="255"
                            rows="3"
                            class="behandeling-edit-textarea"
                        >{{ old('omschrijving', $behandeling->Omschrijving) }}</textarea>
                    </div>

                    <div class="behandeling-edit-grid">
                        <div>
                            <label for="duurminuten" class="behandeling-edit-label">Duur (minuten)</label>
                            <input
                                id="duurminuten"
                                name="duurminuten"
                                type="number"
                                required
                                min="10"
                                max="480"
                                value="{{ old('duurminuten', $behandeling->Duurminuten) }}"
                                class="behandeling-edit-input"
                            >
                        </div>

                        <div>
                            <label for="prijs" class="behandeling-edit-label">Prijs</label>
                            <input
                                id="prijs"
                                name="prijs"
                                type="number"
                                required
                                min="0"
                                max="999999.99"
                                step="0.01"
                                value="{{ old('prijs', $behandeling->Prijs) }}"
                                class="behandeling-edit-input"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="is_actief" class="behandeling-edit-label">Status</label>
                        <select id="is_actief" name="is_actief" required class="behandeling-edit-select">
                            <option value="1" @selected((string) old('is_actief', (int) $behandeling->IsActief) === '1')>Actief</option>
                            <option value="0" @selected((string) old('is_actief', (int) $behandeling->IsActief) === '0')>Inactief</option>
                        </select>
                    </div>

                    <div>
                        <label for="opmerking" class="behandeling-edit-label">Opmerking</label>
                        <textarea
                            id="opmerking"
                            name="opmerking"
                            maxlength="255"
                            rows="3"
                            class="behandeling-edit-textarea"
                        >{{ old('opmerking', $behandeling->Opmerking) }}</textarea>
                    </div>

                    <div class="behandeling-edit-actions">
                        <a href="{{ route('behandelingen.index') }}" class="behandeling-edit-cancel">
                            Annuleren
                        </a>
                        <button type="submit" class="behandeling-edit-save">
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
