import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessor: 'postcss',
        postcss: {
            plugins: [
                require('postcss-import'),
                require('tailwindcss'),
                require('autoprefixer')
            ]
        }
    },
    alias: {
        '@': '/resources/js'
    },
    build: {
        assetsDir: 'public/js',
        css: {
            extract: false
        }
    }
});
