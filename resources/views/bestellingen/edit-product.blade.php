<x-app-layout>
    <main style="min-height:100vh;background:#e6e8ee;padding:38px 0;">
        <div style="max-width:1040px;margin:0 auto;">
            @if (session('error'))
                <div style="max-width:720px;margin-bottom:18px;border:1px solid #fca5a5;background:#fee2e2;color:#991b1b;border-radius:6px;padding:14px 16px;">
                    {{ session('error') }}
                </div>
            @endif

            <div style="font-size:14px;margin-bottom:18px;">
                <a href="{{ route('dashboard') }}" style="color:#d11433;font-weight:600;">Home</a>
                <span style="color:#9ca3af;margin:0 8px;">/</span>
                <a href="{{ route('bestellingen.index') }}" style="color:#d11433;font-weight:600;">Bestellingen</a>
                <span style="color:#9ca3af;margin:0 8px;">/</span>
                <span style="color:#6b7280;font-weight:600;">Producten</span>
            </div>

            <h1 style="color:#d11433;font-size:24px;font-weight:800;margin-bottom:12px;">
                Bestelproduct wijzigen
                <span style="color:#64748b;font-weight:700;">{{ $bestelProduct->ProductNaam }}</span>
            </h1>

            <section style="width:720px;background:white;border-radius:14px;padding:22px;box-shadow:0 1px 2px rgba(0,0,0,0.08);">
                <form
                    method="POST"
                    action="{{ route('bestellingen.producten.update', [$bestelProduct->BestellingId, $bestelProduct->Id]) }}"
                >
                    @csrf
                    @method('PUT')

                    {{-- Security: CSRF-token beschermt dit formulier tegen ongewenste verzoeken. --}}

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px 18px;">
                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;">
                                Bestelnummer
                            </label>
                            <input
                                type="text"
                                value="{{ $bestelProduct->BestelNummer }}"
                                readonly
                                style="width:100%;border:1px solid #cbd5e1;background:#eef3f7;color:#64748b;border-radius:6px;padding:9px 10px;"
                            >
                        </div>

                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;">
                                Bestelstatus
                            </label>
                            <input
                                type="text"
                                value="{{ $bestelProduct->Bestelstatus }}"
                                readonly
                                style="width:100%;border:1px solid #cbd5e1;background:#eef3f7;color:#64748b;border-radius:6px;padding:9px 10px;"
                            >
                        </div>

                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;">
                                Klant
                            </label>
                            <input
                                type="text"
                                value="{{ $bestelProduct->KlantNaam }}"
                                readonly
                                style="width:100%;border:1px solid #cbd5e1;background:#eef3f7;color:#64748b;border-radius:6px;padding:9px 10px;"
                            >
                        </div>

                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;">
                                Relatienummer
                            </label>
                            <input
                                type="text"
                                value="{{ $bestelProduct->Relatienummer }}"
                                readonly
                                style="width:100%;border:1px solid #cbd5e1;background:#eef3f7;color:#64748b;border-radius:6px;padding:9px 10px;"
                            >
                        </div>

                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;">
                                Product
                            </label>
                            <input
                                type="text"
                                value="{{ $bestelProduct->ProductNaam }}"
                                readonly
                                style="width:100%;border:1px solid #cbd5e1;background:#eef3f7;color:#64748b;border-radius:6px;padding:9px 10px;"
                            >
                        </div>

                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;">
                                Categorie
                            </label>
                            <input
                                type="text"
                                value="{{ $bestelProduct->CategorieNaam }}"
                                readonly
                                style="width:100%;border:1px solid #cbd5e1;background:#eef3f7;color:#64748b;border-radius:6px;padding:9px 10px;"
                            >
                        </div>

                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;">
                                Merk
                            </label>
                            <input
                                type="text"
                                value="{{ $bestelProduct->Merk }}"
                                readonly
                                style="width:100%;border:1px solid #cbd5e1;background:#eef3f7;color:#64748b;border-radius:6px;padding:9px 10px;"
                            >
                        </div>

                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;">
                                Unitprijs
                            </label>
                            <input
                                type="text"
                                value="EUR {{ number_format($bestelProduct->UnitPrijs, 2, ',', '.') }}"
                                readonly
                                style="width:100%;border:1px solid #cbd5e1;background:#eef3f7;color:#64748b;border-radius:6px;padding:9px 10px;"
                            >
                        </div>

                        <div>
                            <label for="Aantal" style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;">
                                Aantal <span style="color:#d11433;">*</span>
                            </label>

                            {{-- Client-side validatie: required, min en max controleren invoer al in de browser. --}}
                            <input
                                type="number"
                                id="Aantal"
                                name="Aantal"
                                value="{{ old('Aantal', $bestelProduct->Aantal) }}"
                                min="1"
                                max="999"
                                required
                                style="width:100%;border:1px solid {{ $errors->has('Aantal') ? '#f87171' : '#cbd5e1' }};background:white;color:#334155;border-radius:6px;padding:9px 10px;"
                            >

                            {{-- Server-side validatie: foutmelding vanuit Laravel/controller. --}}
                            @error('Aantal')
                                <div style="margin-top:6px;font-size:13px;color:#dc2626;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <p style="margin-top:14px;font-size:13px;color:#6b7280;">
                        Velden met een <span style="color:#d11433;">*</span> zijn verplicht.
                    </p>

                    <div style="margin-top:20px;display:flex;justify-content:flex-end;gap:8px;">
                        <button
                            type="submit"
                            style="background:#d11433;color:white;border-radius:7px;padding:8px 18px;font-size:13px;font-weight:700;"
                        >
                            Opslaan
                        </button>

                        <a
                            href="{{ route('bestellingen.producten', $bestelProduct->BestellingId) }}"
                            style="background:#64748b;color:white;border-radius:7px;padding:8px 18px;font-size:13px;font-weight:700;"
                        >
                            Terug
                        </a>
                    </div>
                </form>
            </section>

            <footer style="text-align:center;color:#6b7280;font-size:13px;margin-top:46px;">
                © 2026 Kniploket Tiko - Alle rechten voorbehouden
            </footer>
        </div>
    </main>
</x-app-layout>