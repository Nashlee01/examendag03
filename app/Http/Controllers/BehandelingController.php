<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBehandelingRequest;
use App\Models\Behandeling;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class BehandelingController extends Controller
{
    // User Story Read (overzicht):
    // 1) leest de filter uit de request
    // 2) vraagt data op via model-methodes
    // 3) geeft alles door aan de view
    // Zo blijft de controller verantwoordelijk voor flow/orchestratie.
    public function index(Request $request): View
    {
        $geselecteerdeBehandeling = (string) $request->query('behandeling', Behandeling::FILTER_ALLE);
        $dbMelding = null;

        try {
            $behandelingOpties = Behandeling::getFilterOpties();
            $query = Behandeling::buildOverzichtQuery();

            Behandeling::applyOverzichtFilter($query, $geselecteerdeBehandeling);

            $behandelingen = $query->paginate(4)->withQueryString();
        } catch (QueryException $queryException) {
            // Veilige fallback voor examen/demo:
            // als tabellen ontbreken of DB verkeerd staat, tonen we de pagina alsnog
            // met lege data + duidelijke melding, in plaats van een harde foutpagina.
            Log::warning('Behandelingen-overzicht niet beschikbaar door ontbrekende tabel of verkeerde DB-configuratie.', [
                'error' => $queryException->getMessage(),
            ]);

            $behandelingOpties = collect([Behandeling::FILTER_ALLE, Behandeling::FILTER_OVERIG]);
            $behandelingen = new LengthAwarePaginator(
                items: [],
                total: 0,
                perPage: 4,
                currentPage: 1,
                options: [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );
            $dbMelding = 'Behandelingen zijn niet beschikbaar in de huidige database. Voer Sql_dag3.sql uit op MySQL of pas je databaseverbinding aan.';
        }

        return view('behandelingen.index', compact('behandelingen', 'behandelingOpties', 'geselecteerdeBehandeling', 'dbMelding'));
    }

    // Opent het update-formulier van 1 specifieke behandeling.
    public function edit(Behandeling $behandeling): View
    {
        $this->authorizeBehandeling();

        return view('behandelingen.edit', compact('behandeling'));
    }

    // User Story Update:
    // - request valideert server-side via FormRequest
    // - model voert update uit via stored procedure
    // - bij fout loggen we technisch en tonen we gebruikersvriendelijke melding
    public function update(UpdateBehandelingRequest $request, Behandeling $behandeling): RedirectResponse
    {
        $this->authorizeBehandeling();

        $validated = $request->validated();

        try {
            $behandeling->updateViaStoredProcedure($validated);
        } catch (\Throwable $throwable) {
            Log::error('Bijwerken behandeling mislukt.', [
                'behandeling_id' => $behandeling->Id,
                'user_id' => $request->user()?->id,
                'exception' => $throwable->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'De behandeling kon niet worden bijgewerkt. Probeer het opnieuw.');
        }

        return redirect()
            ->route('behandelingen.index')
            ->with('status', 'De behandeling is succesvol bijgewerkt.');
    }

    // Security-regel van deze functionaliteit:
    // alleen de eigenaar mag behandelingen bekijken/bijwerken.
    private function authorizeBehandeling(): void
    {
        $user = auth()->user();

        if (! $user || $user->role !== 'eigenaar') {
            abort(403);
        }
    }
}
