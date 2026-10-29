<x-app-layout>
    <!-- Scenario 02: bij een melding na 4 seconden terug naar Geleverde producten -->
    @if ($melding)
        <x-slot name="head">
            <meta http-equiv="refresh" content="4; url={{ route('leveranciers.producten', $info->LeverancierId) }}">
        </x-slot>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6">

                <h1 class="text-2xl font-normal mb-6">
                    <u>Levering product</u>
                </h1>

                @if ($melding)
                    <!-- Scenario 02: het product wordt niet meer geproduceerd -->
                    <table class="w-full border-collapse border border-black text-center text-base">
                        <tbody>
                            <tr>
                                <td class="border border-black p-6">{{ $melding }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <!-- Gegevens van de leverancier en het product -->
                    <div class="mb-6 space-y-1 text-base text-gray-900">
                        <p>Leverancier: {{ $info->LeverancierNaam }}</p>
                        <p>Product: {{ $info->ProductNaam }}</p>
                    </div>

                    <!-- Scenario 01: het formulier voor een nieuwe levering -->
                    <form method="POST"
                          action="{{ route('leveranciers.levering.store', [$info->LeverancierId, $info->ProductId]) }}"
                          class="max-w-md space-y-4">
                        @csrf

                        <div>
                            <label for="aantal" class="block mb-1 text-base">Aantal producteenheden</label>
                            <input type="number" id="aantal" name="aantal" min="1" value="{{ old('aantal') }}"
                                   class="w-full border border-black p-2">
                            @error('aantal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="datum_eerstvolgende_levering" class="block mb-1 text-base">Datum eerstvolgende levering</label>
                            <input type="date" id="datum_eerstvolgende_levering" name="datum_eerstvolgende_levering"
                                   value="{{ old('datum_eerstvolgende_levering') }}"
                                   class="w-full border border-black p-2">
                            @error('datum_eerstvolgende_levering')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4 items-center">
                            <button type="submit" class="border border-black px-6 py-2 hover:bg-gray-100">
                                Sla op
                            </button>
                            <a href="{{ route('leveranciers.producten', $info->LeverancierId) }}" class="underline text-blue-600">
                                Annuleren
                            </a>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>