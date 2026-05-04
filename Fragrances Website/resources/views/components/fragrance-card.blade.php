@props(['fragrance'])

@php
    $detailUrl = route('fragrances.show', ['slug' => $fragrance['slug'] ?? 'silk-ash']);
@endphp

<article class="group h-full overflow-hidden rounded-2xl border border-white/10 bg-white/[0.02] shadow-soft transition duration-300 hover:-translate-y-1 hover:border-gold/40 hover:bg-white/[0.04]">
    <a href="{{ $detailUrl }}" class="flex h-full flex-col">
        <div class="relative aspect-[4/5] overflow-hidden">
            <img
                src="{{ $fragrance['image'] }}"
                alt="{{ $fragrance['name'] }} bottle"
                class="h-full w-full object-cover object-center transition duration-500 group-hover:scale-[1.03]"
                loading="lazy"
            >
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
            <span class="absolute left-4 top-4 rounded-full border border-gold/50 bg-black/45 px-3 py-1 text-[11px] uppercase tracking-[0.2em] text-gold">
                {{ strtoupper($fragrance['category']) }}
            </span>
        </div>

        <div class="flex flex-1 flex-col gap-2 p-5">
            <h3 class="font-['Playfair_Display'] text-2xl leading-tight text-white">{{ $fragrance['name'] }}</h3>
            <p class="text-sm text-mist">{{ $fragrance['mood'] }}</p>
            <div class="mt-3 flex items-center justify-between text-xs uppercase tracking-[0.16em] text-mist">
                <span>Luxury Edition</span>
                <span class="text-gold">${{ number_format($fragrance['price'], 0) }}</span>
            </div>
        </div>
    </a>
</article>
