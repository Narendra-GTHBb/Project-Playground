<nav x-data="{ menuOpen: false }" class="sticky top-0 z-40 border-b border-white/10 bg-[#0F0F0F]/80 backdrop-blur-xl">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4 lg:px-10">
        <a href="{{ url('/') }}" class="group inline-flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-gold/40 text-sm tracking-[0.22em] text-gold">NA</span>
            <span class="font-['Playfair_Display'] text-xl tracking-wide text-white transition group-hover:text-gold">Noir Atelier</span>
        </a>

        <div class="hidden items-center gap-10 text-sm uppercase tracking-[0.2em] text-mist lg:flex">
            <a href="{{ route('collections') }}" class="transition hover:text-gold">Collections</a>
            <a href="{{ route('detail') }}" class="transition hover:text-gold">Fragrance Detail</a>
            <a href="{{ route('notes') }}" class="transition hover:text-gold">Journal</a>
        </div>

        <button type="button" @click="menuOpen = !menuOpen" class="inline-flex items-center justify-center rounded-lg border border-white/15 p-2 text-white lg:hidden" aria-label="Toggle menu">
            <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
            <svg x-show="menuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-show="menuOpen" x-collapse x-cloak class="border-t border-white/10 bg-[#121212] lg:hidden">
        <div class="mx-auto flex max-w-7xl flex-col gap-5 px-6 py-5 text-sm uppercase tracking-[0.2em] text-mist">
            <a href="{{ route('collections') }}" class="transition hover:text-gold">Collections</a>
            <a href="{{ route('detail') }}" class="transition hover:text-gold">Fragrance Detail</a>
            <a href="{{ route('notes') }}" class="transition hover:text-gold">Journal</a>
        </div>
    </div>
</nav>
