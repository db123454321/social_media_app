<aside class="w-20 lg:w-64 h-screen bg-white border-r border-gray-200 fixed left-0 top-0 overflow-y-auto z-50">
    <div class="flex flex-col h-full">
        <!-- Logo and Title -->
        <div class="p-4 lg:p-6 flex items-center justify-center lg:justify-start">
            <span class="text-3xl hidden lg:inline pinstagram-logo">Pinstagram</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-2">
            @php
                $navItems = [
                    ['route' => 'home', 'label' => 'Home', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>'],
                    ['route' => 'messages', 'label' => 'Messages', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>'],
                    ['route' => 'notifications', 'label' => 'Notifications', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>'],
                    ['route' => 'posts.create', 'label' => 'Create', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>'],
                    ['route' => 'profile.show', 'label' => 'Profile', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" class="flex items-center p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        {!! $item['icon'] !!}
                    </svg>
                    <span class="ml-3 text-sm lg:text-base hidden lg:inline">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Logout Button -->
        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3"></path>
                    </svg>
                    <span class="ml-3 text-sm lg:text-base">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
