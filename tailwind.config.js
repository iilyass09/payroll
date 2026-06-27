import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eff7ff',
                    100: '#dbeefe',
                    200: '#bfdffe',
                    300: '#93c9fd',
                    400: '#60aafa',
                    500: '#0987F5',
                    600: '#036bd1',
                    700: '#0454a8',
                    800: '#084686',
                    900: '#0c3a6f',
                    950: '#08254a',
                },
                violet: {
                    50: '#f3f0ff',
                    100: '#e8e0ff',
                    200: '#d1c0fe',
                    300: '#b495fd',
                    400: '#9665f7',
                    500: '#854DEA',
                    600: '#7332d6',
                    700: '#6027b5',
                    800: '#4f2294',
                    900: '#421d79',
                    950: '#281154',
                },
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out',
                'slide-up': 'slideUp 0.5s ease-out',
                'scale-in': 'scaleIn 0.2s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
            },
        },
    },

    plugins: [forms],
};
