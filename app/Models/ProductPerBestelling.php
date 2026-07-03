<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductPerBestelling extends Model
{
    protected $table = 'ProductPerBestelling';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    /**
     * Haalt alle producten van één bestelling op.
     * JOINs worden gebruikt voor product- en categoriegegevens.
     */
    public static function haalProductenVanBestellingOp(int $bestellingId)
    {
        return DB::table('ProductPerBestelling as ppb')
            ->join('Product as p', 'ppb.ProductId', '=', 'p.Id') // JOIN: bestelregel koppelen aan product
            ->join('Categorie as c', 'p.CategorieId', '=', 'c.Id') // JOIN: product koppelen aan categorie
            ->select(
                'ppb.Id',
                'ppb.BestellingId',
                'ppb.Aantal',
                'ppb.UnitPrijs',
                'ppb.BTWPercentage',
                'ppb.Korting',
                'p.Naam as ProductNaam',
                'p.Merk',
                'c.Naam as CategorieNaam',
                DB::raw('((ppb.Aantal * ppb.UnitPrijs) * (1 - ppb.Korting / 100) * (1 + ppb.BTWPercentage / 100)) as TotaalBedrag')
            )
            ->where('ppb.BestellingId', $bestellingId)
            ->where('ppb.IsActief', 1)
            ->get();
    }

    /**
     * Haalt één bestelproduct op voor het wijzigformulier.
     */
    public static function haalBestelProductOp(int $productPerBestellingId)
    {
        return DB::table('ProductPerBestelling as ppb')
            ->join('Bestelling as b', 'ppb.BestellingId', '=', 'b.Id') // JOIN: bestelregel koppelen aan bestelling
            ->join('Klant as k', 'b.KlantId', '=', 'k.Id') // JOIN: bestelling koppelen aan klant
            ->join('Product as p', 'ppb.ProductId', '=', 'p.Id') // JOIN: bestelregel koppelen aan product
            ->join('Categorie as c', 'p.CategorieId', '=', 'c.Id') // JOIN: product koppelen aan categorie
            ->select(
                'ppb.Id',
                'ppb.BestellingId',
                'ppb.Aantal',
                'ppb.UnitPrijs',
                'ppb.BTWPercentage',
                'ppb.Korting',
                'b.BestelNummer',
                'b.Bestelstatus',
                'k.Relatienummer',
                DB::raw("CONCAT(k.Voornaam, ' ', IFNULL(k.Tussenvoegsel, ''), ' ', k.Achternaam) as KlantNaam"),
                'p.Naam as ProductNaam',
                'p.Merk',
                'c.Naam as CategorieNaam'
            )
            ->where('ppb.Id', $productPerBestellingId)
            ->where('ppb.IsActief', 1)
            ->first();
    }

    /**
     * Wijzigt het aantal via een update-query.
     * Dit wordt pas uitgevoerd na server-side validatie in de controller.
     */
    public static function wijzigAantal(int $productPerBestellingId, int $aantal): int
    {
        return DB::table('ProductPerBestelling')
            ->where('Id', $productPerBestellingId)
            ->where('IsActief', 1)
            ->update([
                'Aantal' => $aantal,
                'DatumGewijzigd' => now(),
            ]);
    }
}