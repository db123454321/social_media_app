<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Profile Information Section -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <div class="relative">
                                <img src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : asset('images/default-avatar.png') }}" 
                                     alt="Profile Picture" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                            </div>
                            <div class="ml-6">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-gray-600">{{ $user->email }}</p>
                                @if($user->bio)
                                    <p class="mt-2 text-gray-700">{{ $user->bio }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="flex justify-end">
                            <a href="{{ route('profile.edit') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Edit Profile') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
