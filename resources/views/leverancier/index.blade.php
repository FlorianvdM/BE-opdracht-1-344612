<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6">

                <h1 class="text-2xl font-normal mb-6">
                    <u>Overzicht Leveranciers</u>
                </h1>

                <!-- class "sorteerbaar" zorgt dat de sorteerknoppen werken -->
                <table class="sorteerbaar w-full border-collapse border border-black text-left text-base">
                    <thead>
                        <tr>
                            <!-- Elke knop in de kop sorteert zijn eigen kolom -->
                            <th class="border border-black p-2 font-normal">
                                <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="0" data-type="tekst">
                                    <span>Naam</span> <span class="pijl">⇅</span>
                                </button>
                            </th>
                            <th class="border border-black p-2 font-normal">
                                <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="1" data-type="tekst">
                                    <span>Contactpersoon</span> <span class="pijl">⇅</span>
                                </button>
                            </th>
                            <th class="border border-black p-2 font-normal">
                                <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="2" data-type="tekst">
                                    <span>Leveranciernummer</span> <span class="pijl">⇅</span>
                                </button>
                            </th>
                            <th class="border border-black p-2 font-normal">
                                <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="3" data-type="tekst">
                                    <span>Mobiel</span> <span class="pijl">⇅</span>
                                </button>
                            </th>
                            <!-- Standaard staat deze kolom aflopend gesorteerd (user story) -->
                            <th class="border border-black p-2 font-normal">
                                <button type="button" class="sorteer-knop flex w-full items-center justify-between gap-2 hover:underline" data-kolom="4" data-type="getal" data-richting="aflopend">
                                    <span>Aantal verschillende producten</span> <span class="pijl">▼</span>
                                </button>
                            </th>
                            <th class="border border-black p-2 text-center font-normal">Toon producten</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Elke leverancier uit de stored procedure krijgt een rij -->
                        @foreach ($leveranciers as $leverancier)
                            <tr>
                                <td class="border border-black p-2">{{ $leverancier->Naam }}</td>
                                <td class="border border-black p-2">{{ $leverancier->ContactPersoon }}</td>
                                <td class="border border-black p-2">{{ $leverancier->LeverancierNummer }}</td>
                                <td class="border border-black p-2">{{ $leverancier->Mobiel }}</td>
                                <td class="border border-black p-2" data-waarde="{{ $leverancier->AantalVerschillendeProducten }}">{{ $leverancier->AantalVerschillendeProducten }}</td>
                                <td class="border border-black p-2 text-center">
                                    <!-- Box-icoon: link naar het scherm Geleverde producten -->
                                    <a href="{{ route('leveranciers.producten', $leverancier->Id) }}"
                                       title="Toon producten"
                                       class="inline-block text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
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

    <!-- Het script dat de sorteerknoppen laat werken -->
    @include('leverancier.sorteer-script')
</x-app-layout>