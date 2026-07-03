<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Behandelingen') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full min-w-[720px] text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left">Klant</th>
                                <th class="py-2 text-left">Datum</th>
                                <th class="py-2 text-left">Start</th>
                                <th class="py-2 text-left">Duur</th>
                                <th class="py-2 text-left">Status</th>
                                <th class="py-2 text-left">Behandelaar</th>
                                <th class="py-2 text-left">Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($behandelingen as $behandeling)
                                <tr class="border-b">
                                    <td class="py-2">{{ $behandeling->klant_naam }}</td>
                                    <td class="py-2">{{ $behandeling->datum }}</td>
                                    <td class="py-2">{{ substr($behandeling->start_tijd, 0, 5) }}</td>
                                    <td class="py-2">{{ $behandeling->duur_minuten }} min</td>
                                    <td class="py-2">{{ ucfirst($behandeling->status) }}</td>
                                    <td class="py-2">{{ $behandeling->behandelaar_naam }}</td>
                                    <td class="py-2">
                                        <a
                                            href="{{ route('behandelingen.edit', $behandeling) }}"
                                            class="rounded bg-indigo-600 px-3 py-1.5 text-white hover:bg-indigo-700"
                                        >
                                            Update
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-gray-500">Geen behandelingen gevonden.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $behandelingen->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
