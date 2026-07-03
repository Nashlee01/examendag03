<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Behandeling extends Model
{
    use HasFactory;

    public const FILTER_ALLE = 'Alle behandelingen';

    public const FILTER_OVERIG = 'Overig';

    protected $table = 'Behandeling';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Omschrijving',
        'Duurminuten',
        'Prijs',
        'IsActief',
        'Opmerking',
    ];

    // Geeft alle opties terug voor de dropdown op het overzichtsscherm.
    // We voegen bewust 2 extra keuzes toe:
    // - Alle behandelingen: toont alles
    // - Overig: hoort volgens de wireframe geen resultaten te tonen
    public static function getFilterOpties(): Collection
    {
        return self::query()
            ->where('IsActief', '=', 1)
            ->orderBy('Naam')
            ->pluck('Naam')
            ->prepend(self::FILTER_ALLE)
            ->push(self::FILTER_OVERIG)
            ->values();
    }

            // Bouwt de basisquery voor User Story Read (overzicht behandelingen).
            // Deze query haalt niet alleen behandeling-gegevens op, maar ook:
            // - aantal gekoppelde producten
            // - namen van medewerkers die de behandeling uitvoeren
            // Dit gebeurt met LEFT JOINs en aggregaties (COUNT/GROUP_CONCAT).
    public static function buildOverzichtQuery(): QueryBuilder
    {
        return DB::table('Behandeling as b')
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
    }

    // Past de keuze uit de dropdown toe op de overzichtsquery.
    // Zo blijft de controller dun en zit querylogica in het model (MVC).
    public static function applyOverzichtFilter(QueryBuilder $query, string $geselecteerdeBehandeling): void
    {
        if ($geselecteerdeBehandeling === self::FILTER_OVERIG) {
            // Wireframe-eis: bij "Overig" moeten er 0 resultaten verschijnen.
            $query->whereRaw('1 = 0');

            return;
        }

        if ($geselecteerdeBehandeling !== self::FILTER_ALLE) {
            $query->where('b.Naam', '=', $geselecteerdeBehandeling);
        }
    }

    // Werkt een behandeling bij via stored procedure.
    // Reden: de opdracht vraagt SQL-first + gebruik van stored procedures.
    public function updateViaStoredProcedure(array $data): void
    {
        DB::statement('CALL sp_update_behandeling(?, ?, ?, ?, ?, ?, ?)', [
            $this->Id,
            $data['naam'],
            $data['omschrijving'],
            $data['duurminuten'],
            $data['prijs'],
            $data['is_actief'],
            $data['opmerking'],
        ]);
    }
}
