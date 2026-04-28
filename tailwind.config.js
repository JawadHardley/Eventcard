import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['DM Serif Display', 'serif'],
            },
            colors: {
                brand: {
                50: '#f0f7ff', 100: '#e0effe', 200: '#baddfd',
                300: '#7dc3fb', 400: '#38a3f7', 500: '#0e84e8',
                600: '#0267c6', 700: '#0352a0', 800: '#074684', 900: '#0c3c6d',
                }
            },
        },
    },

    plugins: [forms],
};
