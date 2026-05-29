@php
    $user = auth()->user();
    $isAdmin = $user->isSuperAdmin();
@endphp

<!-- Mobile Menu Overlay -->
<div x-data="{ mobileMenu: false }" class="lg:hidden">
    <div x-show="mobileMenu" x-cloak
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
         @click="mobileMenu = false">
    </div>

    <!-- Mobile Sidebar -->
    <div x-show="mobileMenu" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-navy-900 shadow-2xl">
        @include('layouts.sidebar-content')
    </div>
</div>

<!-- Desktop Sidebar -->
<aside class="fixed inset-y-0 left-0 z-30 hidden lg:flex lg:flex-col w-64 glass-sidebar shadow-lg">
    @include('layouts.sidebar-content', ['isDesktop' => true])
</aside>

<script>
    function toggleMobileMenu() {
        return { mobileMenu: false };
    }
</script>
