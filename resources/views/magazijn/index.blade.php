<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6">

                <h1 class="text-2xl font-normal mb-6">
                    <u>Overzicht Magazijn Jamin</u>
                </h1>

                <!-- class "sorteerbaar" zorgt dat de sorteerknoppen werken -->
                <table class="sorteerbaar w-full border-collapse border border-black text-left text-base">
                    <thead>
                        <tr>
                            <!-- Standaard staat deze kolom oplopend gesorteerd (de controller sorteert op Barcode) -->
                            <th class="border border-black p-2 font-normal">
                                <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="0" data-type="tekst" data-richting="oplopend">
                                    <span>Barcode</span> <span class="pijl">▲</span>
                                </button>
                            </th>
                            <th class="border border-black p-2 font-normal">
                                <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="1" data-type="tekst">
                                    <span>Naam</span> <span class="pijl">⇅</span>
                                </button>
                            </th>
                            <th class="border border-black p-2 font-normal">
                                <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="2" data-type="getal">
                                    <span>Verpakkingseenheid</span> <span class="pijl">⇅</span>
                                </button>
                            </th>
                            <th class="border border-black p-2 font-normal">
                                <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="3" data-type="getal">
                                    <span>Aantalaanwezig</span> <span class="pijl">⇅</span>
                                </button>
                            </th>
                            <th class="border border-black p-2 text-center font-normal">Allergenen Info</th>
                            <th class="border border-black p-2 text-center font-normal">Leverantie Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($producten as $product)
                            <tr>
                                <td class="border border-black p-2">{{ $product->Barcode }}</td>
                                <td class="border border-black p-2">{{ $product->Naam }}</td>
                                <!-- data-waarde bevat het getal met een punt, zodat het goed sorteert (2,5 wordt 2.5) -->
                                <td class="border border-black p-2" data-waarde="{{ $product->VerpakkingsEenheid }}">{{ str_replace('.', ',', (string)$product->VerpakkingsEenheid) }}</td>
                                <!-- Staat er niets in het magazijn (leeg/NULL)? Dan tonen we 0 -->
                                <td class="border border-black p-2" data-waarde="{{ $product->AantalAanwezig ?? 0 }}">{{ $product->AantalAanwezig ?? 0 }}</td>
                                <td class="border border-black p-2 text-center">
                                    <a href="{{ route('allergeen.show', $product->Id) }}" class="text-red-600 font-bold text-xl no-underline">
                                        X
                                    </a>
                                </td>
                                <td class="border border-black p-2 text-center">
                                    <a href="{{ route('levering.show', $product->Id) }}" class="text-blue-600 font-bold text-xl no-underline">
                                        ?
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Home-knop onder de tabel -->
                <x-terug-knoppen />

            </div>
        </div>
    </div>

    <!-- Hetzelfde script als bij de leveranciersoverzichten laat de sorteerknoppen werken -->
    @include('leverancier.sorteer-script')
</x-app-layout>