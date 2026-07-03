<x-app-layout>
    <div class="min-h-[calc(100vh-56px)] bg-[#dfe2e8] pt-8 pb-6 flex flex-col">
        <div class="mx-auto w-full max-w-[980px] px-4 flex-1">
            <div class="mb-4 text-sm">
                <a href="{{ route('dashboard') }}" class="font-semibold text-[#d11433]">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="font-semibold text-gray-500">Behandelingen</span>
            </div>

            <h1 class="text-[36px] font-extrabold leading-tight text-[#d11433]">Overzicht behandelingen</h1>

            <div class="mt-4 rounded-2xl bg-[#f4f4f4] px-4 py-4 shadow-sm ring-1 ring-black/5">
                <form method="GET" action="{{ route('behandelingen.index') }}" class="flex flex-col justify-end gap-3 md:flex-row md:items-end">
                    <div class="w-full md:w-[290px]">
                        <label for="behandeling" class="mb-1 block text-[13px] font-semibold text-gray-700">Behandeling selecteren</label>
                        <select
                            name="behandeling"
                            id="behandeling"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-[15px] text-gray-700 focus:border-[#d11433] focus:outline-none"
                        >
                            @foreach ($behandelingOpties as $optie)
                                <option value="{{ $optie }}" @selected($geselecteerdeBehandeling === $optie)>{{ $optie }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="rounded-lg bg-[#d11433] px-6 py-2 text-sm font-bold text-white hover:bg-[#bb102d]">
                        Maak selectie
                    </button>

                    <a href="{{ route('behandelingen.index') }}" class="rounded-lg bg-slate-500 px-5 py-2 text-center text-sm font-bold text-white hover:bg-slate-600">
                        Reset
                    </a>
                </form>
            </div>

            <div class="mt-4 rounded-2xl bg-[#f4f4f4] px-4 py-4 shadow-sm ring-1 ring-black/5">
                <div class="mb-3 text-[17px] text-slate-500">
                    Gevonden behandelingen - {{ $behandelingen->total() }} behandeling(en)
                </div>

                @if ($behandelingen->hasPages())
                    <div class="mb-3 flex items-center justify-center gap-2">
                        @if ($behandelingen->onFirstPage())
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 text-gray-300">&lsaquo;</span>
                        @else
                            <a href="{{ $behandelingen->previousPageUrl() }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 text-[#d11433]">&lsaquo;</a>
                        @endif

                        @foreach ($behandelingen->getUrlRange(1, $behandelingen->lastPage()) as $page => $url)
                            @if ($page === $behandelingen->currentPage())
                                <span class="inline-flex h-8 min-w-8 items-center justify-center rounded-lg bg-[#d11433] px-2 text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex h-8 min-w-8 items-center justify-center rounded-lg border border-gray-300 px-2 text-[#d11433]">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($behandelingen->hasMorePages())
                            <a href="{{ $behandelingen->nextPageUrl() }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 text-[#d11433]">&rsaquo;</a>
                        @else
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 text-gray-300">&rsaquo;</span>
                        @endif
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[960px] text-[15px] text-gray-700">
                        <thead>
                            <tr class="bg-[#d11433] text-left text-white">
                                <th class="px-3 py-2">Soort</th>
                                <th class="px-3 py-2">Omschrijving</th>
                                <th class="px-3 py-2">Duur</th>
                                <th class="px-3 py-2">Prijs</th>
                                <th class="px-3 py-2">Aantal producten</th>
                                <th class="px-3 py-2">Medewerkers</th>
                                <th class="px-3 py-2">Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($behandelingen as $behandeling)
                                <tr class="border-b border-gray-300 bg-white/60">
                                    <td class="px-3 py-2">{{ $behandeling->Naam }}</td>
                                    <td class="px-3 py-2">{{ $behandeling->Omschrijving }}</td>
                                    <td class="px-3 py-2">{{ $behandeling->Duurminuten }} min</td>
                                    <td class="px-3 py-2">EUR {{ number_format((float) $behandeling->Prijs, 2, ',', '.') }}</td>
                                    <td class="px-3 py-2">{{ (int) $behandeling->aantal_producten }}</td>
                                    <td class="px-3 py-2">{{ $behandeling->medewerkers ?: '-' }}</td>
                                    <td class="px-3 py-2">
                                        <a
                                            href="{{ route('behandelingen.edit', $behandeling->Id) }}"
                                            class="inline-flex rounded-md border border-[#2f6fed] px-3 py-1 text-[#2f6fed] hover:bg-blue-50"
                                        >
                                            Bijwerken
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white/60">
                                    <td colspan="7" class="px-3 py-4 text-center text-gray-600">Er zijn geen behandelingen bekent met deze naam</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer class="mt-6 text-center text-sm text-gray-500">
            © 2026 Kniploket Tiko - Alle rechten voorbehouden
        </footer>
    </div>
</x-app-layout>
