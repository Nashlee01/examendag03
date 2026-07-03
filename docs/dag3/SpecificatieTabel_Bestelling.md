# Specificatietabel Functionaliteit Bestelling

## Context
Deze specificatietabel hoort bij de functionaliteit:
- Overzicht bestellingen (Read)
- Bestelstatus wijzigen (Update)

De functionaliteit gebruikt een SQL-first aanpak met stored procedures.

## Tabel: Bestelling
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel van bestelling |
| KlantId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Klant(Id) |
| BestelNummer | INT | Nee | UNIQUE | - | Uniek bestelnummer |
| Omschrijving | VARCHAR(255) | Nee | - | - | Omschrijving van bestelling |
| Datum | DATE | Nee | - | - | Besteldatum |
| Tijd | TIME | Nee | - | - | Besteltijd |
| Bestelstatus | ENUM('Ontvangen','Bevestigd','Inverwerking','Verzonden','Afgeleverd') | Nee | - | - | Status van de bestelling |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: ProductPerBestelling
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel bestelregel |
| ProductId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Product(Id) |
| BestellingId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Bestelling(Id) |
| Aantal | INT | Nee | - | - | Aantal producten in regel |
| UnitPrijs | DECIMAL(8,2) | Nee | - | - | Prijs per stuk |
| BTWPercentage | DECIMAL(5,2) | Nee | - | - | BTW-percentage |
| Korting | DECIMAL(5,2) | Nee | - | 0.00 | Korting in procenten |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: Klant
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel klant |
| UserId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar users(id) |
| Voornaam | VARCHAR(100) | Nee | - | - | Voornaam klant |
| Tussenvoegsel | VARCHAR(50) | Ja | - | NULL | Tussenvoegsel |
| Achternaam | VARCHAR(100) | Nee | - | - | Achternaam |
| Relatienummer | VARCHAR(20) | Nee | UNIQUE | - | Uniek relatienummer |
| Bijzonderheden | VARCHAR(255) | Ja | - | NULL | Bijzonderheden klant |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: Contact
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel contact/adres |
| Straatnaam | VARCHAR(100) | Nee | - | - | Straatnaam van adres |
| Huisnummer | INT | Nee | - | - | Huisnummer |
| Toevoeging | VARCHAR(20) | Ja | - | NULL | Huisnummertoevoeging |
| Postcode | VARCHAR(10) | Nee | - | - | Postcode |
| Plaats | VARCHAR(100) | Nee | - | - | Woonplaats |
| Email | VARCHAR(191) | Nee | - | - | E-mailadres contact |
| Mobiel | VARCHAR(25) | Nee | - | - | Mobiel nummer |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: KlantPerContact
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel koppeling |
| KlantId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Klant(Id) |
| ContactId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Contact(Id) |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Tabel: Product
| Kolom | Type | Null | Key | Default | Omschrijving |
|---|---|---|---|---|---|
| Id | BIGINT UNSIGNED AUTO_INCREMENT | Nee | PK | - | Unieke sleutel product |
| CategorieId | BIGINT UNSIGNED | Nee | FK | - | Verwijst naar Categorie(Id) |
| Naam | VARCHAR(100) | Nee | - | - | Productnaam |
| Omschrijving | VARCHAR(255) | Nee | - | - | Productomschrijving |
| Merk | VARCHAR(100) | Nee | - | - | Productmerk |
| EANcode | VARCHAR(20) | Nee | UNIQUE | - | EAN-code |
| Houdbaarheidsdatum | DATE | Nee | - | - | Houdbaarheidsdatum |
| InkoopPrijs | DECIMAL(8,2) | Nee | - | - | Inkoopprijs |
| VerkoopPrijs | DECIMAL(8,2) | Nee | - | - | Verkoopprijs |
| IsActief | BIT | Nee | - | b'1' | Actieve status |
| Opmerking | VARCHAR(255) | Ja | - | NULL | Extra opmerking |
| DatumAangemaakt | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Aanmaakdatum |
| DatumGewijzigd | DATETIME(6) | Nee | - | CURRENT_TIMESTAMP(6) | Wijzigingsdatum |

## Relaties relevant voor de functionaliteit
1. Klant 1..n Bestelling
2. Klant 1..n KlantPerContact
3. Contact 1..n KlantPerContact
4. Bestelling 1..n ProductPerBestelling
5. Product 1..n ProductPerBestelling

## Stored procedures relevant
1. sp_get_bestellingen_overzicht
- Input: geen
- Doel: geeft overzicht van bestellingen met klantnaam via JOIN op Klant

2. sp_update_bestelling_status
- Input: pBestellingId, pBestelstatus
- Doel: wijzigt bestelstatus en DatumGewijzigd van actieve bestelling

## Validatieregels (aanbevolen)
1. Bestelstatus alleen toestaan uit:
- Ontvangen
- Bevestigd
- Inverwerking
- Verzonden
- Afgeleverd

2. Alleen actieve bestellingen mogen geüpdatet worden
- SQL filter: IsActief = b'1'
