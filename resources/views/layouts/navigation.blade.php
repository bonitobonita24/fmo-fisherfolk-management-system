<nav x-data="{ open: false }" class="navbar bg-base-100 shadow-sm border-b border-base-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-base-content" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if(auth()->user()->hasPermission('fisherfolk', 'view'))
                    <x-nav-link :href="route('fisherfolk.index')" :active="request()->routeIs('fisherfolk.*')">
                        {{ __('Fisherfolk') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="btn btn-ghost btn-sm gap-2">
                            <span>{{ Auth::user()->name }}</span>
                            <span class="icon-[tabler--chevron-down] size-4"></span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <li>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        </li>

                        <!-- Authentication -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </li>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="btn btn-ghost btn-square">
                    <span class="icon-[tabler--menu-2] size-6" :class="{'hidden': open, 'inline-flex': ! open }"></span>
                    <span class="icon-[tabler--x] size-6" :class="{'hidden': ! open, 'inline-flex': open }" style="display: none;"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden absolute top-16 left-0 right-0 bg-base-100 shadow-lg z-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(auth()->user()->hasPermission('fisherfolk', 'view'))
            <x-responsive-nav-link :href="route('fisherfolk.index')" :active="request()->routeIs('fisherfolk.*')">
                {{ __('Fisherfolk') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-base-300">
            <div class="px-4">
                <div class="font-medium text-base text-base-content">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-base-content/60">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

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
