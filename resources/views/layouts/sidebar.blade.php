<div class="drawer-side z-40">
    <label for="drawer-toggle" aria-label="close sidebar" class="drawer-overlay"></label>

    <aside class="bg-base-100 w-72 min-h-screen flex flex-col shadow-xl">
        <!-- Logo Section -->
        <div class="sticky top-0 z-10 bg-primary px-6 py-5">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-12 h-12 bg-base-100 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold text-base-100">QRIS Dinamis</span>
                    <span class="text-xs text-base-100/80">Payment Gateway</span>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 overflow-y-auto py-6">
            <!-- Main Menu Section -->
            <div class="mb-6 px-4">
                <div class="mb-3">
                    <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Menu Utama</span>
                </div>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-primary-content font-medium' : 'hover:bg-base-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Transaction Section -->
            <div class="mb-6 px-4">
                <div class="mb-3">
                    <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Transaksi</span>
                </div>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('transactions.index') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('transactions.*') ? 'bg-primary text-primary-content font-medium' : 'hover:bg-base-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="flex-1">Semua Transaksi</span>
                        @if(false) {{-- Example badge --}}
                        <span class="badge badge-sm badge-primary">5</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="mb-6 px-4">
                <div class="mb-3">
                    <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Pengaturan</span>
                </div>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('api-keys.index') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('api-keys.*') ? 'bg-primary text-primary-content font-medium' : 'hover:bg-base-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        <span>API Key</span>
                    </a>
                    <a href="{{ route('settings.index') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('settings.*') ? 'bg-primary text-primary-content font-medium' : 'hover:bg-base-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                </div>
            </div>

            <!-- Help & Support Section -->
            <div class="mb-6 px-4">
                <div class="mb-3">
                    <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Bantuan</span>
                </div>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('documentation.index') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('documentation.*') ? 'bg-primary text-primary-content font-medium' : 'hover:bg-base-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Dokumentasi</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- User Profile Footer -->
        <div class="border-t border-base-300 bg-base-100">
            <!-- User Info Display -->
            <div class="px-4 py-3 hover:bg-base-200 transition-colors cursor-pointer" onclick="toggleUserMenu()">
                <div class="flex items-center gap-3">
                    <div class="avatar">
                        <div class="w-10 h-10 rounded-full">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=0D8ABC&color=fff" alt="User Avatar" />
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Admin User' }}</p>
                        <p class="text-xs text-base-content/60 truncate">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                    </div>
                    <svg id="user-menu-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/60 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                    </svg>
                </div>
            </div>

            <!-- Dropdown Menu -->
            <div id="user-dropdown-menu" class="hidden border-t border-base-300">
                <div class="py-2">
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-base-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm">Profile</span>
                    </a>

                    <div class="border-t border-base-300 my-1"></div>

                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-base-200 transition-colors text-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="text-sm">Log out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function toggleUserMenu() {
            const menu = document.getElementById('user-dropdown-menu');
            const icon = document.getElementById('user-menu-icon');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                menu.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const userSection = event.target.closest('.border-t.border-base-300.bg-base-100');
            const menu = document.getElementById('user-dropdown-menu');
            const icon = document.getElementById('user-menu-icon');

            if (!userSection && menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        });
        </script>
    </aside>
</div>
