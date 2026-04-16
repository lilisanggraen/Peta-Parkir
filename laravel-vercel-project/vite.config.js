import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    // TAMBAHKAN BAGIAN INI:
    build: {
        outDir: 'dist',
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
