@extends('layouts.main')

@section('title', 'Fragrance Detail | Noir Atelier')

@section('content')
<section class="mx-auto w-full max-w-7xl px-6 pt-12 lg:px-10 lg:pt-20">
    <div class="grid items-stretch gap-7 lg:grid-cols-2">
        <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/[0.02] shadow-soft">
            <img src="{{ $fragrance['image'] }}" alt="{{ $fragrance['name'] }} fragrance" class="h-full w-full object-cover object-center">
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/[0.02] p-8 lg:p-10">
            <p class="text-xs uppercase tracking-[0.28em] text-gold">{{ strtoupper($fragrance['category']) }}</p>
            <h1 class="mt-3 font-['Playfair_Display'] text-4xl text-white md:text-5xl">{{ $fragrance['name'] }}</h1>
            <p class="mt-4 text-sm leading-relaxed text-mist md:text-base">{{ $fragrance['mood'] }}</p>

            <div class="mt-8 grid gap-4 rounded-2xl border border-white/10 bg-black/20 p-5">
                <div class="flex items-center justify-between text-xs uppercase tracking-[0.16em] text-mist">
                    <span>Edition</span>
                    <span class="text-white">Parfum Extrait</span>
                </div>
                <div class="flex items-center justify-between text-xs uppercase tracking-[0.16em] text-mist">
                    <span>Price</span>
                    <span class="text-gold">${{ number_format($fragrance['price'], 0) }}</span>
                </div>
            </div>

            <a href="{{ route('collections') }}" class="mt-7 inline-flex rounded-xl border border-gold/50 px-5 py-3 text-xs uppercase tracking-[0.2em] text-gold transition hover:bg-gold hover:text-black">
                Back to Collections
            </a>
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-7xl px-6 pt-12 lg:px-10 lg:pt-16">
    <div class="rounded-3xl border border-white/10 bg-white/[0.02] p-7 lg:p-10">
        <h2 class="font-['Playfair_Display'] text-3xl text-white">Notes Pyramid</h2>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-white/10 bg-black/20 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-gold">Top Notes</p>
                <ul class="mt-4 space-y-2 text-sm text-mist">
                    @foreach ($fragrance['top_notes'] as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-2xl border border-white/10 bg-black/20 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-gold">Middle Notes</p>
                <ul class="mt-4 space-y-2 text-sm text-mist">
                    @foreach ($fragrance['middle_notes'] as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-2xl border border-white/10 bg-black/20 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-gold">Base Notes</p>
                <ul class="mt-4 space-y-2 text-sm text-mist">
                    @foreach ($fragrance['base_notes'] as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-7xl px-6 pt-10 lg:px-10 lg:pt-12">
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl border border-white/10 bg-white/[0.02] p-7 lg:p-10">
            <h3 class="font-['Playfair_Display'] text-2xl text-white">Performance</h3>

            <div class="mt-7 space-y-6">
                <div>
                    <div class="mb-2 flex items-center justify-between text-xs uppercase tracking-[0.16em] text-mist">
                        <span>Longevity</span>
                        <span class="text-white">{{ $fragrance['longevity'] }}</span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-white/10">
                        <div class="h-full rounded-full bg-gradient-to-r from-gold/80 to-gold" style="width: {{ $longevityWidth }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between text-xs uppercase tracking-[0.16em] text-mist">
                        <span>Sillage</span>
                        <span class="text-white">{{ $fragrance['sillage'] }}</span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-white/10">
                        <div class="h-full rounded-full bg-gradient-to-r from-gold/70 to-gold" style="width: {{ $sillageWidth }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/[0.02] p-7 lg:p-10">
            <h3 class="font-['Playfair_Display'] text-2xl text-white">Experience</h3>
            <p class="mt-5 text-sm leading-relaxed text-mist md:text-base">
                {{ $fragrance['story'] }}
            </p>
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-7xl px-6 pb-12 pt-12 lg:px-10 lg:pb-20 lg:pt-16">
    <div class="mb-6 flex items-center justify-between gap-3">
        <h3 class="font-['Playfair_Display'] text-3xl text-white">You May Also Like</h3>
        <a href="{{ route('collections') }}" class="text-xs uppercase tracking-[0.2em] text-gold">View All</a>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($related as $item)
            <x-fragrance-card :fragrance="$item" />
        @endforeach
    </div>
</section>
@endsection
