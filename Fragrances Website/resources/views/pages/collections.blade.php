@extends('layouts.main')

@section('title', 'Collections | Noir Atelier')

@section('content')
<section class="mx-auto w-full max-w-7xl px-6 pt-16 lg:px-10 lg:pt-24">
    <div class="rounded-3xl border border-white/10 bg-white/[0.02] p-8 lg:p-12">
        <p class="mb-3 text-xs uppercase tracking-[0.35em] text-gold/90">Noir Atelier</p>
        <h1 class="font-['Playfair_Display'] text-4xl uppercase tracking-[0.18em] text-white md:text-6xl">Collections</h1>
        <p class="mt-4 max-w-2xl text-sm leading-relaxed text-mist md:text-base">
            Explore signature compositions crafted for evenings, ceremonies, and quiet moments of confidence.
        </p>
    </div>
</section>

<section x-data="{ activeCategory: 'All' }" class="mx-auto w-full max-w-7xl px-6 pt-10 lg:px-10 lg:pt-12">
    <div class="mb-10 overflow-x-auto pb-2">
        <div class="inline-flex min-w-full gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-2">
            @foreach ($categories as $category)
                <button
                    type="button"
                    @click="activeCategory = '{{ $category }}'"
                    class="whitespace-nowrap rounded-xl px-5 py-2.5 text-xs uppercase tracking-[0.18em] transition"
                    :class="activeCategory === '{{ $category }}' ? 'bg-gold text-black' : 'text-mist hover:text-white'"
                >
                    {{ $category }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($fragrances as $item)
            <div x-show="activeCategory === 'All' || activeCategory === '{{ $item['category'] }}'" x-transition.opacity.duration.300ms>
                <x-fragrance-card :fragrance="$item" />
            </div>
        @endforeach
    </div>
</section>
@endsection
