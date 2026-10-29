<x-app-layout>
    <!-- Scenario 02: geen producten, dan na 3 seconden terug naar het overzicht -->
    @if (count($producten) === 0)
        <x-slot name="head">
            <meta http-equiv="refresh" content="3; url={{ route('leveranciers.index') }}">
        </x-slot>
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
                    <table class="w-full border-collapse border border-black text-left text-base">
                        <thead>
                            <tr>
                                <th class="border border-black p-2 font-normal">Naam product</th>
                                <th class="border border-black p-2 font-normal">Aantal in magazijn</th>
                                <th class="border border-black p-2 font-normal">Laatste levering</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producten as $product)
                                <tr>
                                    <td class="border border-black p-2">{{ $product->ProductNaam }}</td>
                                    <td class="border border-black p-2">{{ $product->AantalAanwezig }}</td>
                                    <td class="border border-black p-2">
                                        {{ date('d-m-Y', strtotime($product->DatumLaatsteLevering)) }}
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

            </div>
        </div>
    </div>
</x-app-layout>