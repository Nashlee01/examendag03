<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBehandelingRequest;
use App\Models\Behandeling;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BehandelingController extends Controller
{
    public function index(Request $request): View
    {
        $geselecteerdeBehandeling = (string) $request->query('behandeling', 'Alle behandelingen');

        $behandelingOpties = DB::table('Behandeling')
            ->where('IsActief', '=', 1)
            ->orderBy('Naam')
            ->pluck('Naam')
            ->prepend('Alle behandelingen')
            ->push('Overig')
            ->values();

        $query = DB::table('Behandeling as b')
            ->select([
                'b.Id',
                'b.Naam',
                'b.Omschrijving',
                'b.Duurminuten',
                'b.Prijs',
                DB::raw('COUNT(DISTINCT bpv.VoorraadId) AS aantal_producten'),
                DB::raw("GROUP_CONCAT(DISTINCT TRIM(CONCAT(m.Voornaam, ' ', IFNULL(m.Tussenvoegsel, ''), ' ', m.Achternaam)) ORDER BY m.Voornaam SEPARATOR ', ') AS medewerkers"),
            ])
            ->leftJoin('BehandelingPerVoorraad as bpv', function ($join): void {
                $join->on('bpv.BehandelingId', '=', 'b.Id')
                    ->where('bpv.IsActief', '=', 1);
            })
            ->leftJoin('MedewerkerPerBehandeling as mpb', function ($join): void {
                $join->on('mpb.BehandelingId', '=', 'b.Id')
                    ->where('mpb.IsActief', '=', 1);
            })
            ->leftJoin('Medewerker as m', function ($join): void {
                $join->on('m.Id', '=', 'mpb.MedewerkerId')
                    ->where('m.IsActief', '=', 1);
            })
            ->where('b.IsActief', '=', 1)
            ->groupBy('b.Id', 'b.Naam', 'b.Omschrijving', 'b.Duurminuten', 'b.Prijs')
            ->orderBy('b.Naam');

        if ($geselecteerdeBehandeling === 'Overig') {
            $query->whereRaw('1 = 0');
        } elseif ($geselecteerdeBehandeling !== 'Alle behandelingen') {
            $query->where('b.Naam', '=', $geselecteerdeBehandeling);
        }

        $behandelingen = $query->paginate(4)->withQueryString();

        return view('behandelingen.index', compact('behandelingen', 'behandelingOpties', 'geselecteerdeBehandeling'));
    }

    public function edit(Behandeling $behandeling): View
    {
        $this->authorizeBehandeling($behandeling);

        return view('behandelingen.edit', compact('behandeling'));
    }

    public function update(UpdateBehandelingRequest $request, Behandeling $behandeling): RedirectResponse
    {
        $this->authorizeBehandeling($behandeling);

        $validated = $request->validated();

        try {
            DB::transaction(function () use ($behandeling, $validated): void {
                DB::statement('CALL sp_update_behandeling(?, ?, ?, ?, ?, ?, ?)', [
                    $behandeling->Id,
                    $validated['naam'],
                    $validated['omschrijving'],
                    $validated['duurminuten'],
                    $validated['prijs'],
                    $validated['is_actief'],
                    $validated['opmerking'],
                ]);
            });
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

    private function authorizeBehandeling(Behandeling $behandeling): void
    {
        $user = auth()->user();

        if (! $user || $user->role !== 'eigenaar') {
            abort(403);
        }
    }
}
