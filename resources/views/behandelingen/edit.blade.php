<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Behandeling bijwerken') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('behandelingen.update', $behandeling) }}" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="klant_naam" class="block text-sm font-medium text-gray-700">Klantnaam</label>
                        <input
                            id="klant_naam"
                            name="klant_naam"
                            type="text"
                            required
                            maxlength="120"
                            value="{{ old('klant_naam', $behandeling->klant_naam) }}"
                            class="mt-1 block w-full rounded border-gray-300"
                        >
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="datum" class="block text-sm font-medium text-gray-700">Datum</label>
                            <input
                                id="datum"
                                name="datum"
                                type="date"
                                required
                                value="{{ old('datum', $behandeling->datum) }}"
                                class="mt-1 block w-full rounded border-gray-300"
                            >
                        </div>

                        <div>
                            <label for="start_tijd" class="block text-sm font-medium text-gray-700">Starttijd</label>
                            <input
                                id="start_tijd"
                                name="start_tijd"
                                type="time"
                                required
                                value="{{ old('start_tijd', substr($behandeling->start_tijd, 0, 5)) }}"
                                class="mt-1 block w-full rounded border-gray-300"
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="duur_minuten" class="block text-sm font-medium text-gray-700">Duur (minuten)</label>
                            <input
                                id="duur_minuten"
                                name="duur_minuten"
                                type="number"
                                required
                                min="10"
                                max="180"
                                value="{{ old('duur_minuten', $behandeling->duur_minuten) }}"
                                class="mt-1 block w-full rounded border-gray-300"
                            >
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" required class="mt-1 block w-full rounded border-gray-300">
                                @foreach (['gepland', 'bezig', 'afgerond', 'geannuleerd'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $behandeling->status) === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="opmerking" class="block text-sm font-medium text-gray-700">Opmerking</label>
                        <textarea
                            id="opmerking"
                            name="opmerking"
                            maxlength="2000"
                            rows="4"
                            class="mt-1 block w-full rounded border-gray-300"
                        >{{ old('opmerking', $behandeling->opmerking) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('behandelingen.index') }}" class="rounded border border-gray-300 px-4 py-2 text-gray-700">
                            Annuleren
                        </a>
                        <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
