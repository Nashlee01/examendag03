<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBehandelingRequest;
use App\Models\Behandeling;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BehandelingController extends Controller
{
    public function index(): View
    {
        $behandelingen = Behandeling::query()
            ->select('behandelingen.*', 'users.name as behandelaar_naam')
            ->join('users', 'users.id', '=', 'behandelingen.user_id')
            ->orderByDesc('datum')
            ->orderByDesc('start_tijd')
            ->paginate(10);

        return view('behandelingen.index', compact('behandelingen'));
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
                    $behandeling->id,
                    $validated['klant_naam'],
                    $validated['datum'],
                    $validated['start_tijd'],
                    $validated['duur_minuten'],
                    $validated['status'],
                    $validated['opmerking'],
                ]);
            });
        } catch (\Throwable $throwable) {
            Log::error('Bijwerken behandeling mislukt.', [
                'behandeling_id' => $behandeling->id,
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

        if (! $user || ($behandeling->user_id !== $user->id && $user->role !== 'admin')) {
            abort(403);
        }
    }
}
