<nav x-data="{ open: false }" class="kt-nav">
    <div class="kt-nav-container">
        <div class="kt-nav-row">
            <a href="{{ route('dashboard') }}" title="Ga naar de homepage" class="kt-nav-logo">
                Kniploket Tiko
            </a>

            <div class="kt-nav-links">
                <a href="{{ route('dashboard') }}" title="Open Accounts" class="kt-nav-link">Accounts</a>
                <a href="#" title="Open Medewerkers" class="kt-nav-link">Medewerkers</a>
                <a href="#" title="Open Beschikbaarheid" class="kt-nav-link">Beschikbaarheid</a>
                <a href="#" title="Open Klanten" class="kt-nav-link">Klanten</a>
                <a href="#" title="Open Afspraken" class="kt-nav-link">Afspraken</a>
                <a
                    href="{{ route('behandelingen.index') }}"
                    title="Open Behandelingen"
                    {{-- Als huidige route begint met behandelingen.*, krijgt menu-item de actieve kleur (wireframe-eis). --}}
                    class="kt-nav-link {{ request()->routeIs('behandelingen.*') ? 'is-active' : '' }}"
                >
                    Behandelingen
                </a>
                <a href="#" title="Open Producten" class="kt-nav-link">Producten</a>
                <a href="#" title="Open Bestellingen" class="kt-nav-link">Bestellingen</a>
            </div>

            <div class="kt-nav-account">
                <span class="kt-nav-role">Salon Eigenaar (eigenaar)</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Uitloggen" class="kt-nav-logout">
                        Uitloggen
                    </button>
                </form>
            </div>

            <button @click="open = ! open" class="kt-nav-menu-btn">
                Menu
            </button>
        </div>
    </div>

    <div x-show="open" x-transition class="kt-nav-mobile">
        <div class="kt-nav-mobile-inner">
            <a href="{{ route('dashboard') }}" title="Open Accounts" class="kt-nav-mobile-link">Accounts</a>
            <a href="#" title="Open Medewerkers" class="kt-nav-mobile-link">Medewerkers</a>
            <a href="#" title="Open Beschikbaarheid" class="kt-nav-mobile-link">Beschikbaarheid</a>
            <a href="#" title="Open Klanten" class="kt-nav-mobile-link">Klanten</a>
            <a href="#" title="Open Afspraken" class="kt-nav-mobile-link">Afspraken</a>
            <a
                href="{{ route('behandelingen.index') }}"
                title="Open Behandelingen"
                {{-- Zelfde actieve route-highlight, maar dan voor het mobiele menu. --}}
                class="kt-nav-mobile-link {{ request()->routeIs('behandelingen.*') ? 'is-active' : '' }}"
            >
                Behandelingen
            </a>
            <a href="#" title="Open Producten" class="kt-nav-mobile-link">Producten</a>
            <a href="#" title="Open Bestellingen" class="kt-nav-mobile-link">Bestellingen</a>

            <div class="kt-nav-mobile-role">Salon Eigenaar (eigenaar)</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Uitloggen" class="kt-nav-mobile-logout">
                    Uitloggen
                </button>
            </form>
        </div>
    </div>
</nav>
