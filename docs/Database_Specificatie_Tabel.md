# Database Specificatie Tabel - Magazijn Jamin

**Opdracht:** BE-opdracht 02 (Realiseren userstories)  
**Auteur:** MeulenF  
**Klas:** IO-SD-2509AB  
**Database:** `Jamin`  

---

## 1. Stamtabellen

### 1.1 Tabel: `Product`
Beschrijving: Bevat de basisgegevens van alle snoepgoedproducten.

| Veldnaam | Datatype | Lengte / Precisie | Nullable | Sleutel | Standaardwaarde | Beschrijving |
|---|---|---|---|---|---|---|
| `Id` | INT UNSIGNED | 10 | Nee | PK (Auto Increment) | - | Unieke identifier van het product |
| `Naam` | VARCHAR | 100 | Nee | - | - | Naam van het snoepgoedproduct |
| `Barcode` | VARCHAR | 20 | Nee | - | - | Unieke streepjescode (EAN) |
| `IsActief` | BIT | 1 | Nee | - | 1 | Geeft aan of het product nog wordt gemaakt (0 = niet meer) |
| `Opmerking` | VARCHAR | 255 | Ja | - | NULL | Optionele opmerkingen |
| `DatumAangemaakt` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van creatie record |
| `DatumGewijzigd` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van laatste wijziging |

---

### 1.2 Tabel: `Leverancier`
Beschrijving: Bevat de contact- en identificatiegegevens van leveranciers.

| Veldnaam | Datatype | Lengte / Precisie | Nullable | Sleutel | Standaardwaarde | Beschrijving |
|---|---|---|---|---|---|---|
| `Id` | INT UNSIGNED | 10 | Nee | PK (Auto Increment) | - | Unieke identifier van de leverancier |
| `Naam` | VARCHAR | 100 | Nee | - | - | Naam van het leveranciersbedrijf |
| `ContactPersoon` | VARCHAR | 100 | Nee | - | - | Naam van de vaste contactpersoon |
| `LeverancierNummer` | VARCHAR | 20 | Nee | - | - | Uniek nummer van de leverancier (bijv. L1029384719) |
| `Mobiel` | VARCHAR | 20 | Nee | - | - | Mobiel telefoonnummer contactpersoon |
| `IsActief` | BIT | 1 | Nee | - | 1 | Geeft aan of record actief is |
| `Opmerking` | VARCHAR | 255 | Ja | - | NULL | Optionele opmerkingen |
| `DatumAangemaakt` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van creatie record |
| `DatumGewijzigd` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van laatste wijziging |

---

### 1.3 Tabel: `Allergeen`
Beschrijving: Bevat de lijst met bekende allergenen die in snoepgoed kunnen voorkomen.

| Veldnaam | Datatype | Lengte / Precisie | Nullable | Sleutel | Standaardwaarde | Beschrijving |
|---|---|---|---|---|---|---|
| `Id` | INT UNSIGNED | 10 | Nee | PK (Auto Increment) | - | Unieke identifier van het allergeen |
| `Naam` | VARCHAR | 100 | Nee | - | - | Naam van het allergeen (bijv. Gluten, Soja) |
| `Omschrijving` | VARCHAR | 255 | Nee | - | - | Beschrijving van het allergeen |
| `IsActief` | BIT | 1 | Nee | - | 1 | Geeft aan of record actief is |
| `Opmerking` | VARCHAR | 255 | Ja | - | NULL | Optionele opmerkingen |
| `DatumAangemaakt` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van creatie record |
| `DatumGewijzigd` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van laatste wijziging |

---

## 2. Koppeltabellen en Afhankelijke Tabellen

### 2.1 Tabel: `Magazijn`
Beschrijving: Bevat de actuele voorraad en verpakkingseenheid van producten in het magazijn.

| Veldnaam | Datatype | Lengte / Precisie | Nullable | Sleutel | Standaardwaarde | Beschrijving |
|---|---|---|---|---|---|---|
| `Id` | INT UNSIGNED | 10 | Nee | PK (Auto Increment) | - | Unieke identifier voorraadregel |
| `ProductId` | INT UNSIGNED | 10 | Nee | FK naar `Product(Id)` | - | Referentie naar het gekoppelde product |
| `VerpakkingsEenheid` | DECIMAL | 4,1 | Nee | - | - | Gewicht per verpakkingseenheid in kg |
| `AantalAanwezig` | INT | 10 | Ja | - | NULL | Aantal verpakkingen op voorraad (NULL wordt in de website als 0 getoond) |
| `IsActief` | BIT | 1 | Nee | - | 1 | Geeft aan of record actief is |
| `Opmerking` | VARCHAR | 255 | Ja | - | NULL | Optionele opmerkingen |
| `DatumAangemaakt` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van creatie record |
| `DatumGewijzigd` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van laatste wijziging |

**Foreign Keys:**
- `FK_Magazijn_ProductId`: `ProductId` verwijst naar `Product(Id)` met `ON DELETE CASCADE ON UPDATE CASCADE`.

---

### 2.2 Tabel: `ProductPerAllergeen`
Beschrijving: Koppeltabel tussen producten en allergenen (veel-op-veel relatie).

| Veldnaam | Datatype | Lengte / Precisie | Nullable | Sleutel | Standaardwaarde | Beschrijving |
|---|---|---|---|---|---|---|
| `Id` | INT UNSIGNED | 10 | Nee | PK (Auto Increment) | - | Unieke identifier koppelregel |
| `ProductId` | INT UNSIGNED | 10 | Nee | FK naar `Product(Id)` | - | Referentie naar product |
| `AllergeenId` | INT UNSIGNED | 10 | Nee | FK naar `Allergeen(Id)` | - | Referentie naar allergeen |
| `IsActief` | BIT | 1 | Nee | - | 1 | Geeft aan of record actief is |
| `Opmerking` | VARCHAR | 255 | Ja | - | NULL | Optionele opmerkingen |
| `DatumAangemaakt` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van creatie record |
| `DatumGewijzigd` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van laatste wijziging |

**Foreign Keys:**
- `FK_ProductPerAllergeen_ProductId`: `ProductId` verwijst naar `Product(Id)` met `ON DELETE CASCADE ON UPDATE CASCADE`.
- `FK_ProductPerAllergeen_AllergeenId`: `AllergeenId` verwijst naar `Allergeen(Id)` met `ON DELETE CASCADE ON UPDATE CASCADE`.

---

### 2.3 Tabel: `ProductPerLeverancier`
Beschrijving: Registreert leveringen van producten door leveranciers inclusief verwachte vervolglevering.

| Veldnaam | Datatype | Lengte / Precisie | Nullable | Sleutel | Standaardwaarde | Beschrijving |
|---|---|---|---|---|---|---|
| `Id` | INT UNSIGNED | 10 | Nee | PK (Auto Increment) | - | Unieke identifier leveringsregel |
| `LeverancierId` | INT UNSIGNED | 10 | Nee | FK naar `Leverancier(Id)` | - | Referentie naar de leverancier |
| `ProductId` | INT UNSIGNED | 10 | Nee | FK naar `Product(Id)` | - | Referentie naar het geleverde product |
| `DatumLevering` | DATE | - | Nee | - | - | Datum van levering |
| `Aantal` | INT | 10 | Nee | - | - | Aantal geleverde eenheden |
| `DatumEerstVolgendeLevering` | DATE | - | Ja | - | NULL | Verwachte datum van eerstvolgende levering |
| `IsActief` | BIT | 1 | Nee | - | 1 | Geeft aan of record actief is |
| `Opmerking` | VARCHAR | 255 | Ja | - | NULL | Optionele opmerkingen |
| `DatumAangemaakt` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van creatie record |
| `DatumGewijzigd` | DATETIME | 6 | Nee | - | CURRENT_TIMESTAMP(6) | Tijdstip van laatste wijziging |

**Foreign Keys:**
- `FK_ProductPerLeverancier_LeverancierId`: `LeverancierId` verwijst naar `Leverancier(Id)` met `ON DELETE CASCADE ON UPDATE CASCADE`.
- `FK_ProductPerLeverancier_ProductId`: `ProductId` verwijst naar `Product(Id)` met `ON DELETE CASCADE ON UPDATE CASCADE`.

---

## 3. Relaties tussen de tabellen

| Relatie | Soort | Uitleg |
|---|---|---|
| `Product` en `Magazijn` | 1 op 1 | Elk product heeft één voorraadregel in het magazijn |
| `Product` en `Allergeen` | veel op veel | Via de koppeltabel `ProductPerAllergeen` |
| `Product` en `Leverancier` | veel op veel | Via de koppeltabel `ProductPerLeverancier`, met per levering een datum en aantal |

---

## 4. Stored procedures (opdracht 2)

Alle gegevens voor de website worden opgehaald of gewijzigd met stored procedures. Ze worden aangeroepen met PDO vanuit de models `Leverancier` en `Levering`. De procedures staan in de migrations `create_stored_procedures_leverancier` en `create_stored_procedures_levering`.

| Procedure | Parameters | Doel | Gebruikte tabellen |
|---|---|---|---|
| `sp_OverzichtLeveranciers` | geen | Alle leveranciers met het aantal verschillende producten, aflopend gesorteerd op dat aantal (User story 1, scenario 01) | `Leverancier`, `ProductPerLeverancier` |
| `sp_GetLeverancier` | `p_LeverancierId` | Haalt de gegevens van één leverancier op | `Leverancier` |
| `sp_GeleverdeProducten` | `p_LeverancierId` | Verschillende producten van een leverancier met aantal in het magazijn en datum van de laatste levering, aflopend gesorteerd op aantal in het magazijn (User story 1, scenario 01 en 02) | `ProductPerLeverancier`, `Product`, `Magazijn` |
| `sp_GetProductVanLeverancier` | `p_LeverancierId`, `p_ProductId` | Haalt leverancier- en productgegevens op voor het formulier "Levering product" | `Leverancier`, `ProductPerLeverancier`, `Product`, `Magazijn` |
| `sp_NieuweLevering` | `p_LeverancierId`, `p_ProductId`, `p_Aantal`, `p_DatumEerstVolgendeLevering` | Controleert of het product actief is. Zo ja: slaat de levering op en verhoogt de voorraad in één transactie (User story 2, scenario 01). Zo nee: slaat niets op en geeft `Gelukt = 0` terug (User story 2, scenario 02) | `Product`, `ProductPerLeverancier`, `Magazijn` |

---

## 5. Wijzigingen ten opzichte van opdracht 1

- Het veld `Opmerking` is van `VARCHAR(250)` naar `VARCHAR(255)` gewijzigd, zoals de opdracht vraagt.
- Er is een zesde leverancier toegevoegd: **Quality Street** (nog geen leveringen, nodig voor user story 1, scenario 02).
- Het product **Winegums** staat op `IsActief = 0` (nodig voor user story 2, scenario 02).
- De leverdata in `ProductPerLeverancier` staan in november 2024, zoals in de opdracht.
- Alle tabellen gebruiken de opslagmethode InnoDB, zodat de Foreign Keys werken.