{{-- Pop-up bovenaan het scherm. type: "fout" (rood) of "succes" (groen).
     seconden: na hoeveel seconden hij vanzelf verdwijnt (leeg = blijft staan). --}}
@props(['type' => 'fout', 'seconden' => null])

@php
    // Kies de kleuren op basis van het type melding
    $kleuren = $type === 'succes'
        ? 'bg-green-100 border-green-600 text-green-800'
        : 'bg-red-100 border-red-600 text-red-800';
@endphp

<div x-data="{ open: true, seconden: {{ (int) $seconden }} }"
     x-init="if (seconden > 0) { setTimeout(() => open = false, seconden * 1000) }"
     x-show="open"
     role="alert"
     class="fixed top-4 left-1/2 z-50 w-full max-w-xl -translate-x-1/2 px-4">
    <div class="flex items-start justify-between gap-4 border-2 p-4 shadow-lg {{ $kleuren }}">
        <p>{{ $slot }}</p>
        <!-- Kruisje om de pop-up te sluiten -->
        <button type="button" @click="open = false" class="text-xl leading-none" aria-label="Sluiten">&times;</button>
    </div>
</div>