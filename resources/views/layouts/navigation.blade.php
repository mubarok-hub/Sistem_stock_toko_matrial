<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a
                        href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('kasir.produk.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if (auth()->user()->role == 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard Admin') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.produk.index')" :active="request()->routeIs('admin.produk.*')">
                                {{ __('Produk') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.transaksi.index')" :active="request()->routeIs('admin.transaksi.*')">
                                {{ __('Transaksi') }}
                            </x-nav-link>
                        @elseif(auth()->user()->role == 'kasir')
                            <x-nav-link :href="route('kasir.produk.index')" :active="request()->routeIs('kasir.produk.*')">
                                {{ __('Produk') }}
                            </x-nav-link>
                            <x-nav-link :href="route('kasir.transaksi.index')" :active="request()->routeIs('kasir.transaksi.*')">
                                {{ __('Transaksi') }}
                            </x-nav-link>
                            <x-nav-link :href="route('kasir.riwayat')" :active="request()->routeIs('kasir.riwayat')">
                                {{ __('Riwayat') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative">
                    <button id="user-menu-button" 
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                                </svg>
                        </div>
                    </button>

                    <div id="user-menu" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button id="mobile-menu-button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-menu" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if (auth()->user()->role == 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard Admin') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.produk.index')" :active="request()->routeIs('admin.produk.*')">
                        {{ __('Produk') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.transaksi.index')" :active="request()->routeIs('admin.transaksi.*')">
                        {{ __('Transaksi') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->role == 'kasir')
                    <x-responsive-nav-link :href="route('kasir.produk.index')" :active="request()->routeIs('kasir.produk.*')">
                        {{ __('Produk') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('kasir.transaksi.index')" :active="request()->routeIs('kasir.transaksi.*')">
                        {{ __('Transaksi') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('kasir.riwayat')" :active="request()->routeIs('kasir.riwayat')">
                        {{ __('Riwayat') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
