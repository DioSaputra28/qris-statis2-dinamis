<div class="bg-base-100 border-b border-base-300 sticky top-0 z-30 shadow-sm px-6 py-5 flex items-center gap-4">
    <!-- Mobile Menu Toggle -->
    <div class="flex-none lg:hidden">
        <label for="drawer-toggle" class="btn btn-square btn-ghost hover:bg-base-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </label>
    </div>

    <!-- Page Title & Breadcrumb -->
    <div class="flex-1">
        <div class="flex flex-col">
            <h1 class="text-xl font-bold text-base-content">@yield('title', 'Dashboard')</h1>
            <div class="text-sm breadcrumbs p-0 h-5">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-base-content/60 hover:text-primary">Home</a></li>
                    <li class="text-base-content/80">@yield('title', 'Dashboard')</li>
                </ul>
            </div>
        </div>
    </div>
</div>
