<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your profile picture.') }}
        </p>
    </header>

    <div>
        <x-input-label for="picture" :value="__('Profile Picture')" />
        <input id="picture" name="picture" type="file" class="mt-1 block w-full" accept="image/*" />
        <x-input-error class="mt-2" :messages="$errors->get('picture')" />
    </div>

    @if($user->profile_picture)
        <div>
            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ __('Profile Picture') }}" class="mt-2 w-32 h-32 object-cover rounded-full">
        </div>
    @endif
</section>
