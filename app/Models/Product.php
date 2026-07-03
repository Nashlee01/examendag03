<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'Product';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    // Producten die aan een behandeling gekoppeld zijn via voorraad.
    public static function getByBehandeling(int $behandelingId): Collection
    {
        return DB::table('BehandelingPerVoorraad as bpv')
            ->join('Voorraad as v', 'v.Id', '=', 'bpv.VoorraadId')
            ->join('Product as p', 'p.Id', '=', 'v.ProductId')
            ->select([
                'p.Id',
                'p.Naam',
                'p.Merk',
                'p.Omschrijving',
                'p.EANcode',
                'v.AantalOpVoorraad',
                'p.VerkoopPrijs',
            ])
            ->where('bpv.BehandelingId', '=', $behandelingId)
            ->where('bpv.IsActief', '=', 1)
            ->where('v.IsActief', '=', 1)
            ->where('p.IsActief', '=', 1)
            ->orderBy('p.Naam')
            ->get();
    }

    // Detailpagina van 1 product binnen een behandeling, inclusief leverancierinfo.
    public static function getDetailByBehandeling(int $behandelingId, int $productId): ?object
    {
        $latestSupplierSub = DB::table('LeverancierOrder as lo')
            ->select('lo.ProductId', DB::raw('MAX(lo.Id) as LaatsteOrderId'))
            ->where('lo.IsActief', '=', 1)
            ->groupBy('lo.ProductId');

        return DB::table('BehandelingPerVoorraad as bpv')
            ->join('Voorraad as v', 'v.Id', '=', 'bpv.VoorraadId')
            ->join('Product as p', 'p.Id', '=', 'v.ProductId')
            ->leftJoinSub($latestSupplierSub, 'ls', function ($join): void {
                $join->on('ls.ProductId', '=', 'p.Id');
            })
            ->leftJoin('LeverancierOrder as lo', 'lo.Id', '=', 'ls.LaatsteOrderId')
            ->leftJoin('Leverancier as l', 'l.Id', '=', 'lo.LeverancierId')
            ->select([
                'p.Id',
                'p.Naam',
                'p.Merk',
                'p.Omschrijving',
                'p.EANcode',
                'p.Houdbaarheidsdatum',
                'p.InkoopPrijs',
                'p.VerkoopPrijs',
                'p.Opmerking',
                'v.AantalOpVoorraad',
                'l.Naam as LeverancierNaam',
                'l.Postcode as LeverancierPostcode',
                'l.Plaats as LeverancierPlaats',
                'l.Email as LeverancierEmail',
                'l.Mobiel as LeverancierMobiel',
            ])
            ->where('bpv.BehandelingId', '=', $behandelingId)
            ->where('p.Id', '=', $productId)
            ->where('bpv.IsActief', '=', 1)
            ->where('v.IsActief', '=', 1)
            ->where('p.IsActief', '=', 1)
            ->first();
    }

    public static function getInkoopPrijs(int $productId): ?float
    {
        $inkoopPrijs = DB::table('Product')
            ->where('Id', '=', $productId)
            ->value('InkoopPrijs');

        return $inkoopPrijs !== null ? (float) $inkoopPrijs : null;
    }

    // Wijziging loopt via stored procedure conform opdracht.
    public static function updateVerkoopPrijsViaProcedure(int $productId, float $nieuweVerkoopPrijs): void
    {
        DB::statement('CALL sp_update_product_verkoopprijs(?, ?)', [
            $productId,
            $nieuweVerkoopPrijs,
        ]);
    }
}
