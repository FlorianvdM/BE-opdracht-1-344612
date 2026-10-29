<x-app-layout>
    <!-- Scenario 02: geen producten, dan na 3 seconden terug naar het overzicht -->
    @if (count($producten) === 0)
        <x-slot name="head">
            <meta http-equiv="refresh" content="3; url={{ route('leveranciers.index') }}">
        </x-slot>
    @endif

    <!-- Groene pop-up bovenaan na het opslaan van een nieuwe levering (verdwijnt na 4 seconden) -->
    @if (session('status'))
        <x-popup type="succes" :seconden="4">{{ session('status') }}</x-popup>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6">

                <h1 class="text-2xl font-normal mb-6">
                    <u>Geleverde producten</u>
                </h1>

                <!-- Gegevens van de gekozen leverancier -->
                <div class="mb-6 space-y-1 text-base text-gray-900">
                    <p>Leverancier: {{ $leverancier->Naam }}</p>
                    <p>Contactpersoon: {{ $leverancier->ContactPersoon }}</p>
                    <p>Leveranciernummer: {{ $leverancier->LeverancierNummer }}</p>
                    <p>Mobiel: {{ $leverancier->Mobiel }}</p>
                </div>

                @if (count($producten) > 0)
                    <!-- Scenario 01: tabel met de geleverde producten -->
                    <table class="sorteerbaar w-full border-collapse border border-black text-left text-base">
                        <thead>
                            <tr>
                                <th class="border border-black p-2 font-normal">
                                    <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="0" data-type="tekst">
                                        <span>Naam product</span> <span class="pijl">⇅</span>
                                    </button>
                                </th>
                                <th class="border border-black p-2 font-normal">
                                    <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="1" data-type="getal">
                                        <span>Verpakkingseenheid (kg)</span> <span class="pijl">⇅</span>
                                    </button>
                                </th>
                                <!-- Standaard staat deze kolom aflopend gesorteerd (user story) -->
                                <th class="border border-black p-2 font-normal">
                                    <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="2" data-type="getal" data-richting="aflopend">
                                        <span>Aantal in magazijn</span> <span class="pijl">▼</span>
                                    </button>
                                </th>
                                <th class="border border-black p-2 font-normal">
                                    <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="3" data-type="datum">
                                        <span>Laatste levering</span> <span class="pijl">⇅</span>
                                    </button>
                                </th>
                                <th class="border border-black p-2 text-center font-normal">Nieuwe levering</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producten as $product)
                                <tr>
                                    <td class="border border-black p-2">{{ $product->ProductNaam }}</td>
                                    <!-- Verpakkingseenheid met een komma, zoals bij Overzicht Magazijn Jamin -->
                                    <td class="border border-black p-2" data-waarde="{{ $product->VerpakkingsEenheid }}">{{ str_replace('.', ',', (string) $product->VerpakkingsEenheid) }}</td>
                                    <!-- Staat er niets in het magazijn (leeg/NULL)? Dan tonen we 0 -->
                                    <td class="border border-black p-2" data-waarde="{{ $product->AantalAanwezig ?? 0 }}">{{ $product->AantalAanwezig ?? 0 }}</td>
                                    <td class="border border-black p-2" data-waarde="{{ $product->DatumLaatsteLevering }}">
                                        {{ date('d-m-Y', strtotime($product->DatumLaatsteLevering)) }}
                                    </td>
                                    <td class="border border-black p-2 text-center">
                                        <!-- Plus-icoon: link naar het formulier Levering product -->
                                        <a href="{{ route('leveranciers.levering.create', [$leverancier->Id, $product->ProductId]) }}"
                                           title="Nieuwe levering"
                                           class="inline-block text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <!-- Scenario 02: melding dat dit bedrijf nog niets heeft geleverd -->
                    <table class="w-full border-collapse border border-black text-center text-base">
                        <tbody>
                            <tr>
                                <td class="border border-black p-6">
                                    Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif

                <!-- Home en Terug naar het overzicht, onder de tabel -->
                <x-terug-knoppen :terug="route('leveranciers.index')" terug-tekst="Terug naar overzicht" />

            </div>
        </div>
    </div>

    <!-- Het script dat de sorteerknoppen laat werken (alleen nodig als er een tabel is) -->
    @if (count($producten) > 0)
        @include('leverancier.sorteer-script')
    @endif
</x-app-layout>