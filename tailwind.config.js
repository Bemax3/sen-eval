import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from "tailwindcss/colors.js";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './node_modules/vue-tailwind-datepicker/**/*.js'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Oswald', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "s-blue": {
                    '50': '#ecf8ff',
                    '100': '#d4eeff',
                    '200': '#b2e4ff',
                    '300': '#7dd5ff',
                    '400': '#41baff',
                    '500': '#1597ff',
                    '600': '#014acc',
                    '700': '#073a8b',
                    '800': '#073a8b',
                    '900': '#073a8b',
                    '950': '#0b2960',
                },
                's-green': {
                    '50': '#ecfffe',
                    '100': '#d0fdfd',
                    '200': '#a6fafb',
                    '300': '#69f5f7',
                    '400': '#25e5eb',
                    '500': '#09c8d1',
                    '600': '#0aa0b0',
                    '700': '#118a9a',
                    '800': '#166674',
                    '900': '#175562',
                    '950': '#093943',
                },
                's-pink': {
                    '50': '#fff0fb',
                    '100': '#ffe4f9',
                    '200': '#ffc8f5',
                    '300': '#ff9beb',
                    '400': '#ff5ddb',
                    '500': '#ff2dc8',
                    '600': '#af016e',
                    '700': '#950660',
                    '800': '#950660',
                    '900': '#950660',
                    '950': '#5c0037',
                },
                'dark-gray': '#0E0E10',
                'grayish': '#18181B',
                "vtd-primary": colors.cyan,

            }
        },

    },
    darkMode: 'class',

    plugins: [forms],
};
