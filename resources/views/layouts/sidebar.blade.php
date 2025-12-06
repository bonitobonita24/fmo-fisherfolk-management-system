{{-- Sidebar Navigation Component --}}
<aside id="sidebar" class="sidebar fixed start-0 top-0 z-70 h-screen w-64 bg-base-100 border-e border-base-300 transition-all duration-300 -translate-x-full lg:translate-x-0">
    {{-- Sidebar Header / Logo --}}
    <div class="sidebar-header flex items-center justify-between h-16 px-4 border-b border-base-300">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="bg-primary/10 rounded-lg p-2">
                <span class="icon-[tabler--fish] size-6 text-primary"></span>
            </div>
            <span class="text-lg font-bold text-base-content">FMO System</span>
        </a>
        <button id="sidebar-close" class="btn btn-ghost btn-sm btn-square lg:hidden">
            <span class="icon-[tabler--x] size-5"></span>
        </button>
    </div>

    {{-- Sidebar Body --}}
    <div class="sidebar-body overflow-y-auto h-[calc(100vh-8rem)] px-3 py-4">
        <ul class="menu menu-sm gap-1">
            {{-- Dashboard --}}
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                    <span class="icon-[tabler--layout-dashboard] size-5"></span>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Fisherfolk Management --}}
            @if(auth()->user()->hasPermission('fisherfolk', 'view'))
            <li class="menu-title mt-4">
                <span class="text-xs uppercase tracking-wider text-base-content/50">Management</span>
            </li>
            <li>
                <a href="{{ route('fisherfolk.index') }}" class="{{ request()->routeIs('fisherfolk.index') ? 'menu-active' : '' }}">
                    <span class="icon-[tabler--users] size-5"></span>
                    <span>All Fisherfolk</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasPermission('fisherfolk', 'create'))
            <li>
                <a href="{{ route('fisherfolk.create') }}" class="{{ request()->routeIs('fisherfolk.create') ? 'menu-active' : '' }}">
                    <span class="icon-[tabler--user-plus] size-5"></span>
                    <span>Register New</span>
                </a>
            </li>
            @endif

            {{-- Reports Section --}}
            <li class="menu-title mt-4">
                <span class="text-xs uppercase tracking-wider text-base-content/50">Reports</span>
            </li>
            <li>
                <a href="#" class="opacity-50 cursor-not-allowed">
                    <span class="icon-[tabler--chart-bar] size-5"></span>
                    <span>Statistics</span>
                    <span class="badge badge-xs badge-neutral">Soon</span>
                </a>
            </li>
            <li>
                <a href="#" class="opacity-50 cursor-not-allowed">
                    <span class="icon-[tabler--file-text] size-5"></span>
                    <span>Export Data</span>
                    <span class="badge badge-xs badge-neutral">Soon</span>
                </a>
            </li>

            {{-- Settings Section --}}
            <li class="menu-title mt-4">
                <span class="text-xs uppercase tracking-wider text-base-content/50">Account</span>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'menu-active' : '' }}">
                    <span class="icon-[tabler--settings] size-5"></span>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Sidebar Footer --}}
    <div class="sidebar-footer absolute bottom-0 start-0 end-0 border-t border-base-300 p-3">
        <div class="flex items-center gap-3">
            <div class="avatar avatar-placeholder">
                <div class="bg-primary text-primary-content w-10 rounded-full">
                    <span class="text-sm font-medium">{{ substr(Auth::user()->name, 0, 2) }}</span>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-base-content truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-base-content/60 truncate">{{ Auth::user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm btn-square" title="Logout">
                    <span class="icon-[tabler--logout] size-5"></span>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Sidebar Overlay (Mobile) --}}
<div id="sidebar-overlay" class="fixed inset-0 z-60 bg-black/50 hidden lg:hidden" onclick="toggleSidebar()"></div>

{{-- Top Header --}}
<header class="fixed top-0 start-0 end-0 z-50 lg:start-64 bg-base-100 border-b border-base-300 transition-all duration-300">
    <div class="flex items-center justify-between h-16 px-4 lg:px-6">
        {{-- Left Section --}}
        <div class="flex items-center gap-4">
            {{-- Mobile Menu Toggle --}}
            <button id="sidebar-toggle" class="btn btn-ghost btn-sm btn-square lg:hidden">
                <span class="icon-[tabler--menu-2] size-5"></span>
            </button>
            
            {{-- Page Title / Breadcrumb --}}
            @isset($header)
                <div class="hidden sm:block">
                    {{ $header }}
                </div>
            @endisset
        </div>

        {{-- Right Section --}}
        <div class="flex items-center gap-2">
            {{-- Search Button --}}
            <button class="btn btn-ghost btn-sm btn-square">
                <span class="icon-[tabler--search] size-5"></span>
            </button>

            {{-- Notifications --}}
            <div class="dropdown dropdown-end">
                <button class="btn btn-ghost btn-sm btn-square indicator">
                    <span class="icon-[tabler--bell] size-5"></span>
                    <span class="indicator-item badge badge-xs badge-primary"></span>
                </button>
                <div class="dropdown-menu dropdown-open:opacity-100 w-80 max-h-96 overflow-y-auto">
                    <div class="dropdown-header justify-between">
                        <span class="text-base font-medium">Notifications</span>
                        <span class="badge badge-primary badge-soft badge-sm">3 New</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="p-3 text-center text-base-content/60 text-sm">
                        No new notifications
                    </div>
                </div>
            </div>

            {{-- User Dropdown --}}
            <div class="dropdown dropdown-end">
                <button class="btn btn-ghost btn-sm gap-2">
                    <div class="avatar avatar-placeholder">
                        <div class="bg-primary text-primary-content w-8 rounded-full">
                            <span class="text-xs font-medium">{{ substr(Auth::user()->name, 0, 2) }}</span>
                        </div>
                    </div>
                    <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                    <span class="icon-[tabler--chevron-down] size-4"></span>
                </button>
                <ul class="dropdown-menu dropdown-open:opacity-100 w-48">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <span class="icon-[tabler--user] size-4"></span>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <span class="icon-[tabler--settings] size-4"></span>
                            Settings
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-error w-full">
                                <span class="icon-[tabler--logout] size-4"></span>
                                Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    document.getElementById('sidebar-toggle')?.addEventListener('click', toggleSidebar);
    document.getElementById('sidebar-close')?.addEventListener('click', toggleSidebar);
</script>
