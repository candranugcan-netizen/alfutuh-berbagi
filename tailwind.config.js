import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Manrope', ...defaultTheme.fontFamily.sans],
                display: ['"Plus Jakarta Sans"', 'Manrope', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#F2F7F4',
                    100: '#E1EFE8',
                    200: '#C5DFD4',
                    300: '#9EBFB1',
                    400: '#4D967F',
                    500: '#1B735D',
                    600: '#155E4B',
                    700: '#0F4839',
                    800: '#0C392E',
                    900: '#08271F',
                },
                accent: {
                    gold: '#D4AF37',
                    amber: '#F59E0B',
                },
                ink: '#0F172A',
                canvas: '#F8FAF8',
            },
        },
    },

    plugins: [forms],
};
