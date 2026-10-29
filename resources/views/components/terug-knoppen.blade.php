{{-- Knoppen onder een pagina: altijd Home, en optioneel een Terug-knop --}}
@props(['terug' => null, 'terugTekst' => 'Terug'])

<div class="mt-6 flex gap-3">
    <a href="{{ route('dashboard') }}" class="border border-black px-4 py-1 hover:bg-gray-100">
        Home
    </a>

    @if ($terug)
        <a href="{{ $terug }}" class="border border-black px-4 py-1 hover:bg-gray-100">
            {{ $terugTekst }}
        </a>
    @endif
</div>