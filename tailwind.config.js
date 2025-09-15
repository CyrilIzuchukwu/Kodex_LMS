import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    DEFAULT: "#ef8d2d", // warm orange
                    600: "#dd7a18",
                    700: "#c96911",
                },
                'theme-1': '#10b981',
                'theme-green': '#10b981',
                'theme-purple': '#8b5cf6',
                'theme-red': '#ef4444'
            },
            borderRadius: {
                xl: "0.75rem",
            },
            maxWidth: {
                '1500px': '1500px'
            }
        },
        darkMode: "class",
    },

    plugins: [forms],
};
