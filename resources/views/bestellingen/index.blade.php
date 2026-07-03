<x-app-layout>
    <main style="min-height:100vh;background:#e6e8ee;padding:40px 0;">
        <div style="max-width:1200px;margin:0 auto;">

            <div style="font-size:14px;margin-bottom:18px;">
                <a href="{{ route('dashboard') }}" style="color:#d11433;font-weight:600;">Home</a>
                <span style="color:#9ca3af;margin:0 8px;">/</span>
                <span style="color:#6b7280;font-weight:600;">Bestellingen</span>
            </div>

            <h1 style="color:#d11433;font-size:28px;font-weight:800;margin-bottom:12px;">
                Overzicht bestellingen
            </h1>

            <section style="background:white;border-radius:14px;padding:18px;margin-bottom:12px;">
                <form method="GET" action="{{ route('bestellingen.index') }}" style="display:flex;justify-content:flex-end;align-items:end;gap:12px;">
                    <div style="width:290px;">
                        <label for="status" style="display:block;font-size:13px;font-weight:700;margin-bottom:4px;">
                            Status selecteren
                        </label>

                        <select
                            id="status"
                            name="status"
                            style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px;background:white;"
                        >
                            <option value="">Alle statussen</option>

                            @foreach ($statussen as $statusOptie)
                                <option value="{{ $statusOptie }}" @selected($status === $statusOptie)>
                                    {{ $statusOptie }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button
                        type="submit"
                        style="background:#d11433;color:white;border-radius:8px;padding:10px 24px;font-weight:700;"
                    >
                        Maak selectie
                    </button>

                    <a
                        href="{{ route('bestellingen.index') }}"
                        style="background:#64748b;color:white;border-radius:8px;padding:10px 24px;font-weight:700;"
                    >
                        Reset
                    </a>
                </form>
            </section>

            <section style="background:white;border-radius:14px;padding:14px;">
                <p style="color:#64748b;font-size:14px;margin-bottom:12px;">
                    Gevonden bestellingen - {{ $bestellingen->total() }} bestelling(en)
                </p>

                <div style="display:flex;justify-content:center;gap:8px;margin-bottom:12px;">
                    @if ($bestellingen->onFirstPage())
                        <span style="border:1px solid #d1d5db;border-radius:8px;padding:6px 11px;color:#d1d5db;">
                            ‹
                        </span>
                    @else
                        <a
                            href="{{ $bestellingen->previousPageUrl() }}"
                            style="border:1px solid #d1d5db;border-radius:8px;padding:6px 11px;color:#d11433;"
                        >
                            ‹
                        </a>
                    @endif

                    @for ($i = 1; $i <= $bestellingen->lastPage(); $i++)
                        <a
                            href="{{ $bestellingen->url($i) }}"
                            style="border:1px solid #d1d5db;border-radius:8px;padding:6px 11px;{{ $bestellingen->currentPage() === $i ? 'background:#d11433;color:white;' : 'color:#d11433;' }}"
                        >
                            {{ $i }}
                        </a>
                    @endfor

                    @if ($bestellingen->hasMorePages())
                        <a
                            href="{{ $bestellingen->nextPageUrl() }}"
                            style="border:1px solid #d1d5db;border-radius:8px;padding:6px 11px;color:#d11433;"
                        >
                            ›
                        </a>
                    @else
                        <span style="border:1px solid #d1d5db;border-radius:8px;padding:6px 11px;color:#d1d5db;">
                            ›
                        </span>
                    @endif
                </div>

                <table style="width:100%;border-collapse:collapse;font-size:14px;color:#374151;">
                    <thead>
                        <tr style="background:#d11433;color:white;text-align:left;">
                            <th style="padding:9px;">Bestelnr.</th>
                            <th style="padding:9px;">Klant</th>
                            <th style="padding:9px;">Relatienr.</th>
                            <th style="padding:9px;">Datum</th>
                            <th style="padding:9px;">Tijd</th>
                            <th style="padding:9px;">Status</th>
                            <th style="padding:9px;">Producten</th>
                            <th style="padding:9px;">Totaal</th>
                            <th style="padding:9px;">Actie</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bestellingen as $bestelling)
                            <tr style="border-bottom:1px solid #d1d5db;">
                                <td style="padding:9px;">{{ $bestelling->BestelNummer }}</td>
                                <td style="padding:9px;">{{ $bestelling->KlantNaam }}</td>
                                <td style="padding:9px;">{{ $bestelling->Relatienummer }}</td>
                                <td style="padding:9px;">{{ date('d-m-Y', strtotime($bestelling->Datum)) }}</td>
                                <td style="padding:9px;">{{ substr($bestelling->Tijd, 0, 5) }}</td>
                                <td style="padding:9px;">{{ $bestelling->Bestelstatus }}</td>
                                <td style="padding:9px;">{{ $bestelling->AantalProducten }}</td>
                                <td style="padding:9px;">EUR {{ number_format($bestelling->TotaalBedrag ?? 0, 2, ',', '.') }}</td>
                                <td style="padding:9px;">
                                    <a
                                        href="{{ route('bestellingen.producten', $bestelling->Id) }}"
                                        style="display:inline-block;border:1px solid #3b82f6;color:#2563eb;border-radius:6px;padding:4px 13px;font-size:13px;font-weight:600;"
                                    >
                                        Producten
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center;padding:22px;">
                                    Er zijn geen bestellingen bekend met deze status
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <footer style="text-align:center;color:#6b7280;font-size:14px;margin-top:28px;">
                © 2026 Kniploket Tiko - Alle rechten voorbehouden
            </footer>
        </div>
    </main>
</x-app-layout>