<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6">

                <h1 class="text-2xl font-normal mb-6">
                    <u>Overzicht Leveranciers</u>
                </h1>

                <table class="w-full border-collapse border border-black text-left text-base">
                    <thead>
                        <tr>
                            <th class="border border-black p-2 font-normal">Naam</th>
                            <th class="border border-black p-2 font-normal">Contactpersoon</th>
                            <th class="border border-black p-2 font-normal">Leveranciernummer</th>
                            <th class="border border-black p-2 font-normal">Mobiel</th>
                            <th class="border border-black p-2 font-normal">Aantal verschillende producten</th>
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
                                <td class="border border-black p-2">{{ $leverancier->AantalVerschillendeProducten }}</td>
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

            </div>
        </div>
    </div>
</x-app-layout>