<x-app-layout>
    <x-slot name="header">
        <h2 class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 active:opacity-80 focus:outline-none focus:ring ring-pink-300 disabled:opacity-25 transition ease-in-out duration-150 bg-gradient-to-r from-pink-500 to-purple-600">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 active:opacity-80 focus:outline-none focus:ring ring-pink-300 disabled:opacity-25 transition ease-in-out duration-150 bg-gradient-to-r from-pink-500 to-purple-600">
                    <!-- Profile Picture Section -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <div class="relative">
                                <img src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : asset('images/default-avatar.png') }}" 
                                     alt="Profile Picture" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                                <button type="button" 
                                        onclick="document.getElementById('profile_picture').click()" 
                                        class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 hover:bg-blue-600">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-lg font-medium text-gray-900">Profile Picture</h3>
                                <p class="text-sm text-gray-600">Click the camera icon to update your profile picture</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('profile.updateProfilePicture') }}" method="POST" enctype="multipart/form-data" id="profile-picture-form" class="hidden">
                            @csrf
                            @method('POST')
                            <input type="file" 
                                   name="picture" 
                                   id="profile_picture" 
                                   class="hidden"
                                   accept="image/*"
                                   onchange="this.form.submit()">
                        </form>
                    </div>

                    <!-- Profile Information Form -->
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea name="bio" 
                                      id="bio" 
                                      rows="4" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 active:opacity-80 focus:outline-none focus:ring ring-pink-300 disabled:opacity-25 transition ease-in-out duration-150 bg-gradient-to-r from-pink-500 to-purple-600">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview image before upload
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('img').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
    @endpush
</x-app-layout>
