<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bestelling extends Model
{
    protected $table = 'Bestelling';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    /**
     * Haalt het overzicht van bestellingen op.
     * JOINs worden gebruikt om klantgegevens, aantal producten en totaalbedrag te tonen.
     */
    public static function haalOverzichtOp(?string $status = null)
    {
        $query = DB::table('Bestelling as b')
            ->join('Klant as k', 'b.KlantId', '=', 'k.Id') // JOIN: bestelling koppelen aan klant
            ->leftJoin('ProductPerBestelling as ppb', 'b.Id', '=', 'ppb.BestellingId') // JOIN: producten per bestelling tellen
            ->select(
                'b.Id',
                'b.BestelNummer',
                'b.Datum',
                'b.Tijd',
                'b.Bestelstatus',
                'k.Relatienummer',
                DB::raw("CONCAT(k.Voornaam, ' ', IFNULL(k.Tussenvoegsel, ''), ' ', k.Achternaam) as KlantNaam"),
                DB::raw('COUNT(ppb.Id) as AantalProducten'),
                DB::raw('SUM((ppb.Aantal * ppb.UnitPrijs) * (1 - ppb.Korting / 100) * (1 + ppb.BTWPercentage / 100)) as TotaalBedrag')
            )
            ->where('b.IsActief', 1)
            ->groupBy(
                'b.Id',
                'b.BestelNummer',
                'b.Datum',
                'b.Tijd',
                'b.Bestelstatus',
                'k.Relatienummer',
                'k.Voornaam',
                'k.Tussenvoegsel',
                'k.Achternaam'
            )
            ->orderByDesc('b.Datum')
            ->orderByDesc('b.Tijd');

        if (!empty($status)) {
            $query->where('b.Bestelstatus', $status);
        }

        return $query->paginate(4)->withQueryString();
    }

    /**
     * Haalt één bestelling op met klantgegevens.
     */
    public static function haalBestellingMetKlantOp(int $bestellingId)
    {
        return DB::table('Bestelling as b')
            ->join('Klant as k', 'b.KlantId', '=', 'k.Id') // JOIN: bestelling koppelen aan klant
            ->select(
                'b.*',
                'k.Relatienummer',
                DB::raw("CONCAT(k.Voornaam, ' ', IFNULL(k.Tussenvoegsel, ''), ' ', k.Achternaam) as KlantNaam")
            )
            ->where('b.Id', $bestellingId)
            ->where('b.IsActief', 1)
            ->first();
    }

    /**
     * Controleert of een bestelling nog gewijzigd mag worden.
     */
    public static function magAantalWijzigen(string $bestelstatus): bool
    {
        return $bestelstatus !== 'Afgeleverd';
    }
}