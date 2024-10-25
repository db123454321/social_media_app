<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Add custom styles for Instagram-like appearance */
            body {
                background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
                color: #262626;
            }
            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
                100% {
                    background-position: 0% 50%;
                }
            }
            .logo {
                font-family: 'Grand Hotel', cursive;
                font-size: 2.5rem;
                color: #ffffff; /* Changed to white for better contrast */
            }
            .instagram-button {
                background-color: #0095f6;
                color: #ffffff;
                font-weight: 600;
                padding: 0.5rem 1rem;
                border-radius: 0.25rem;
                transition: background-color 0.3s;
            }
            .instagram-button:hover {
                background-color: #1877f2;
            }
        </style>
        <!-- Add Google Fonts link for the cursive font -->
        <link href="https://fonts.googleapis.com/css2?family=Grand+Hotel&display=swap" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/" class="logo">
                    Pinstagram
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
