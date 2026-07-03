# Specificatietabel Functionaliteit Behandeling Producten

## Context
Deze specificatietabel hoort bij de functionaliteit:
- Overzicht behandelingen (Read)
- Bestaande behandeling wijzigen via productprijs (Update)

De functionaliteit gebruikt een SQL-first aanpak met stored procedures.

## Tabel: Behandeling
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel van behandeling |
| Naam | VARCHAR(100) | Nee | - | - | Naam van de behandeling |
| Omschrijving | VARCHAR(255) | Nee | - | - | Beschrijving van de behandeling |
| Duurminuten | INT | Nee | - | - | Duur in minuten |
| Prijs | DECIMAL(8,2) | Nee | - | - | Basisprijs behandeling |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: Product
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel van product |
| CategorieId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Categorie(Id) |
| Naam | VARCHAR(100) | Nee | - | - | Productnaam |
| Omschrijving | VARCHAR(255) | Nee | - | - | Productomschrijving |
| Merk | VARCHAR(100) | Nee | - | - | Productmerk |
| EANcode | VARCHAR(20) | Nee | UNIQUE | - | EAN code |
| Houdbaarheidsdatum | DATE | Nee | - | - | Houdbaarheidsdatum |
| InkoopPrijs | DECIMAL(8,2) | Nee | - | - | Inkoopprijs product |
| VerkoopPrijs | DECIMAL(8,2) | Nee | - | - | Verkoopprijs product |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: Voorraad
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel voorraadregel |
| ProductId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Product(Id) |
| AantalOpVoorraad | INT | Nee | - | - | Huidige voorraad |
| Aantaluitgegeven | INT | Nee | - | 0 | Aantal uitgegeven |
| Aantalbijgekomen | INT | Nee | - | 0 | Aantal bijgekomen |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: BehandelingPerVoorraad
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel koppeling |
| BehandelingId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Behandeling(Id) |
| VoorraadId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Voorraad(Id) |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: Leverancier
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel leverancier |
| Naam | VARCHAR(150) | Nee | - | - | Naam leverancier |
| Straatnaam | VARCHAR(100) | Nee | - | - | Straat |
| Huisnummer | INT | Nee | - | - | Huisnummer |
| Toevoeging | VARCHAR(20) | Ja | - | NULL | Toevoeging |
| Postcode | VARCHAR(10) | Nee | - | - | Postcode |
| Plaats | VARCHAR(100) | Nee | - | - | Plaats |
| Email | VARCHAR(191) | Nee | - | - | E-mailadres |
| Mobiel | VARCHAR(25) | Nee | - | - | Mobiel nummer |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: LeverancierOrder
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel order |
| Ordernummer | VARCHAR(20) | Nee | UNIQUE | - | Extern ordernummer |
| ProductId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Product(Id) |
| LeverancierId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Leverancier(Id) |
| Aantal | INT | Nee | - | - | Besteld aantal |
| Orderdatum | DATE | Nee | - | - | Datum bestelling |
| Leverdatum | DATE | Ja | - | NULL | Datum levering |
| Leverstatus | ENUM('Inbehandeling','Geleverd','Nietleverbaar') | Nee | - | - | Status levering |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Relaties relevant voor de functionaliteit
1. Behandeling 1..n BehandelingPerVoorraad
2. Voorraad 1..n BehandelingPerVoorraad
3. Product 1..n Voorraad
4. Product 1..n LeverancierOrder
5. Leverancier 1..n LeverancierOrder

## Stored procedures relevant
1. sp_update_product_verkoopprijs
- Input: pProductId, pNieuweVerkoopPrijs
- Doel: VerkoopPrijs en DatumGewijzigd bijwerken van actief product

2. sp_update_behandeling
- Input: pBehandelingId, pNaam, pOmschrijving, pDuurminuten, pPrijs, pIsActief, pOpmerking
- Doel: Gegevens van behandeling bijwerken

## Validatieregel user story update
Nieuwe verkoopprijs moet minimaal 30% boven de inkoopprijs liggen.
Formule: nieuwe_verkoopprijs >= inkoopprijs * 1.30
