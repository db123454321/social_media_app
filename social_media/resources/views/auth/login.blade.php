<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-pink-200 via-purple-200 to-indigo-200">
        <div class="flex flex-col items-center mb-8">
            <h1 class="text-6xl font-semibold instagram-gradient" style="font-family: 'Dancing Script', cursive;">
                Pinstagram
            </h1>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-text-input id="email" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="{{ __('Email') }}" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-text-input id="password" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password"
                                    placeholder="{{ __('Password') }}" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="mb-4">
                    <x-primary-button class="w-full justify-center bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <div class="flex items-center justify-between text-sm">
                    @if (Route::has('password.request'))
                        <a class="text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a class="text-indigo-600 hover:underline" href="{{ route('register') }}">
                            {{ __('Sign up') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap');
    
    .instagram-gradient {
        background: -webkit-linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
</style>
