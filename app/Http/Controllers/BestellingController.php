<?php

namespace App\Http\Controllers;

use App\Models\Bestelling;
use App\Models\ProductPerBestelling;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BestellingController extends Controller
{
    public function index(Request $request): View
    {
        $toegestaneStatussen = [
            'Ontvangen',
            'Bevestigd',
            'Inverwerking',
            'Verzonden',
            'Afgeleverd',
            'Geannuleerd',
        ];

        $status = $request->query('status');

        // Security/server-side validatie: alleen bekende statussen toestaan.
        if ($status !== null && !in_array($status, $toegestaneStatussen, true)) {
            $status = null;
        }

        try {
            $bestellingen = Bestelling::haalOverzichtOp($status);
        } catch (\Throwable $exception) {
            // Technische log: fout opslaan zonder technische details aan gebruiker te tonen.
            Log::error('Fout bij ophalen bestellingen', [
                'melding' => $exception->getMessage(),
            ]);

            $bestellingen = collect();
        }

        return view('bestellingen.index', [
            'bestellingen' => $bestellingen,
            'status' => $status,
            'statussen' => $toegestaneStatussen,
        ]);
    }

    public function producten(int $bestelling): View|RedirectResponse
    {
        try {
            $bestellingGegevens = Bestelling::haalBestellingMetKlantOp($bestelling);

            if (!$bestellingGegevens) {
                return redirect()
                    ->route('bestellingen.index')
                    ->with('error', 'Bestelling is niet gevonden.');
            }

            $producten = ProductPerBestelling::haalProductenVanBestellingOp($bestelling);
        } catch (\Throwable $exception) {
            // Try/catch + technische log voor databasefouten.
            Log::error('Fout bij ophalen producten per bestelling', [
                'bestelling_id' => $bestelling,
                'melding' => $exception->getMessage(),
            ]);

            return redirect()
                ->route('bestellingen.index')
                ->with('error', 'Producten van de bestelling konden niet worden opgehaald.');
        }

        return view('bestellingen.producten', [
            'bestelling' => $bestellingGegevens,
            'producten' => $producten,
        ]);
    }

    public function editProduct(int $bestelling, int $productPerBestelling): View|RedirectResponse
    {
        try {
            $bestelProduct = ProductPerBestelling::haalBestelProductOp($productPerBestelling);

            if (!$bestelProduct || (int) $bestelProduct->BestellingId !== $bestelling) {
                return redirect()
                    ->route('bestellingen.producten', $bestelling)
                    ->with('error', 'Bestelproduct is niet gevonden.');
            }
        } catch (\Throwable $exception) {
            Log::error('Fout bij openen wijzigformulier bestelproduct', [
                'bestelling_id' => $bestelling,
                'product_per_bestelling_id' => $productPerBestelling,
                'melding' => $exception->getMessage(),
            ]);

            return redirect()
                ->route('bestellingen.producten', $bestelling)
                ->with('error', 'Het wijzigformulier kon niet worden geopend.');
        }

        return view('bestellingen.edit-product', [
            'bestelProduct' => $bestelProduct,
        ]);
    }

    public function updateProduct(Request $request, int $bestelling, int $productPerBestelling): RedirectResponse
    {
        try {
            $bestelProduct = ProductPerBestelling::haalBestelProductOp($productPerBestelling);

            if (!$bestelProduct || (int) $bestelProduct->BestellingId !== $bestelling) {
                return redirect()
                    ->route('bestellingen.index')
                    ->with('error', 'Bestelproduct is niet gevonden.');
            }

            // Business rule: afgeleverde bestellingen mogen niet gewijzigd worden.
            if (!Bestelling::magAantalWijzigen($bestelProduct->Bestelstatus)) {
                return back()
                    ->withInput()
                    ->with('error', 'Gegevens zijn niet gewijzigd')
                    ->withErrors([
                        'Aantal' => 'Aantal kan niet worden gewijzigd omdat de bestelling al is afgeleverd.',
                    ]);
            }

            // Server-side validatie: Laravel controleert het aantal veilig op de server.
            $validated = $request->validate([
                'Aantal' => ['required', 'integer', 'min:1', 'max:999'],
            ], [
                'Aantal.required' => 'Aantal is verplicht.',
                'Aantal.integer' => 'Aantal moet een heel getal zijn.',
                'Aantal.min' => 'Aantal moet minimaal 1 zijn.',
                'Aantal.max' => 'Aantal mag maximaal 999 zijn.',
            ]);

            ProductPerBestelling::wijzigAantal($productPerBestelling, (int) $validated['Aantal']);

            return redirect()
                ->route('bestellingen.producten', $bestelling)
                ->with('success', 'Aantal producten bijgewerkt.');
        } catch (\Throwable $exception) {
            Log::error('Fout bij wijzigen bestelproduct', [
                'bestelling_id' => $bestelling,
                'product_per_bestelling_id' => $productPerBestelling,
                'melding' => $exception->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gegevens zijn niet gewijzigd');
        }
    }
}