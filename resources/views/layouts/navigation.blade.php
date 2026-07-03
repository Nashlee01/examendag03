<nav x-data="{ open: false }" class="border-b border-[#b90f2d] bg-[#cc0f2f] text-white">
    <div class="mx-auto max-w-[1180px] px-2 sm:px-3 lg:px-4">
        <div class="flex h-14 items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}" title="Ga naar de homepage" class="-ml-7 sm:-ml-9 lg:-ml-[52px] shrink-0 text-3xl font-black tracking-wide leading-none uppercase">
                Kniploket Tiko
            </a>

            <div class="hidden lg:ml-16 lg:flex lg:items-center lg:gap-5 text-[15px] font-semibold">
                <a href="{{ route('dashboard') }}" title="Open Accounts" class="hover:opacity-90">Accounts</a>
                <a href="#" title="Open Medewerkers" class="hover:opacity-90">Medewerkers</a>
                <a href="#" title="Open Beschikbaarheid" class="hover:opacity-90">Beschikbaarheid</a>
                <a href="#" title="Open Klanten" class="hover:opacity-90">Klanten</a>
                <a href="#" title="Open Afspraken" class="hover:opacity-90">Afspraken</a>
                <a href="{{ route('behandelingen.index') }}" title="Open Behandelingen" class="hover:opacity-90">Behandelingen</a>
                <a href="#" title="Open Producten" class="hover:opacity-90">Producten</a>
                <a href="#" title="Open Bestellingen" class="hover:opacity-90">Bestellingen</a>
            </div>

            <div class="hidden lg:flex lg:items-center lg:gap-3">
                <span class="whitespace-nowrap text-xs font-semibold text-white/85">Salon Eigenaar (eigenaar)</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Uitloggen" class="rounded-md border border-white/70 px-3 py-1 text-sm font-semibold hover:bg-white/10">
                        Uitloggen
                    </button>
                </form>
            </div>

            <button @click="open = ! open" class="lg:hidden rounded border border-white/60 px-2 py-1 text-sm font-semibold">
                Menu
            </button>
        </div>
    </div>

    <div x-show="open" x-transition class="border-t border-white/25 bg-[#b90f2d] lg:hidden">
        <div class="space-y-2 px-4 py-3 text-sm font-semibold">
            <a href="{{ route('dashboard') }}" title="Open Accounts" class="block">Accounts</a>
            <a href="#" title="Open Medewerkers" class="block">Medewerkers</a>
            <a href="#" title="Open Beschikbaarheid" class="block">Beschikbaarheid</a>
            <a href="#" title="Open Klanten" class="block">Klanten</a>
            <a href="#" title="Open Afspraken" class="block">Afspraken</a>
            <a href="{{ route('behandelingen.index') }}" title="Open Behandelingen" class="block">Behandelingen</a>
            <a href="#" title="Open Producten" class="block">Producten</a>
            <a href="#" title="Open Bestellingen" class="block">Bestellingen</a>

            <div class="pt-2 text-xs text-white/80">Salon Eigenaar (eigenaar)</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Uitloggen" class="mt-2 rounded-md border border-white/70 px-3 py-1 text-sm font-semibold">
                    Uitloggen
                </button>
            </form>
        </div>
    </div>
</nav>
