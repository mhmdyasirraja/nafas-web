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
                sans: ['"Inter Variable"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                status: {
                    aman: '#23845B',
                    waspada: '#A56A0B',
                    bahaya: '#C53E42',
                },
                sidebar: {
                    DEFAULT: '#0F3D2E', // PLACEHOLDER, verifikasi ke PDF Visual Specifications
                },
            },
        },
    },

    plugins: [forms],
};
