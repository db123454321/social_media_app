const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            gradientColorStops: theme => ({
                'instagram-yellow': '#feda75',
                'instagram-orange': '#fa7e1e',
                'instagram-pink': '#d62976',
                'instagram-purple': '#962fbf',
                'instagram-blue': '#4f5bd5',
            })
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
