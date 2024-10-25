<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notifications') }}
            </h2>
            <div class="flex space-x-4">
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Mark All as Read
                    </button>
                </form>
                <form action="{{ route('notifications.clear-all') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                        Clear All
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($notifications->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                        <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
                    </div>
                @else
                    @foreach($notifications as $notification)
                        <div class="mb-4 p-4 {{ $notification->read_at ? 'bg-gray-50' : 'bg-blue-50' }} rounded-lg hover:bg-gray-100 transition duration-150 ease-in-out">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3">
                                    <!-- User Avatar -->
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($notification->data['user_name']) }}&color=7F9CF5&background=EBF4FF" alt="{{ $notification->data['user_name'] }}">
                                    </div>
                                    
                                    <!-- Notification Content -->
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            @if($notification->read_at === null)
                                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                            @endif
                                            <p class="text-sm text-gray-800">
                                                @if($notification->data['type'] === 'post_liked')
                                                    <a href="{{ route('users.show', $notification->data['user_id']) }}" class="font-semibold hover:text-blue-600">
                                                        {{ $notification->data['user_name'] }}
                                                    </a>
                                                    liked your 
                                                    <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="text-blue-600 hover:underline">
                                                        post
                                                    </a>
                                                @elseif($notification->data['type'] === 'post_commented')
                                                    <a href="{{ route('users.show', $notification->data['user_id']) }}" class="font-semibold hover:text-blue-600">
                                                        {{ $notification->data['user_name'] }}
                                                    </a>
                                                    commented on your 
                                                    <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="text-blue-600 hover:underline">
                                                        post
                                                    </a>
                                                @endif
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2">
                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.read', $notification) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out">
                                                Mark as read
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 transition duration-150 ease-in-out">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
