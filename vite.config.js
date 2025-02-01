import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/admin/genres.js',
                'resources/js/admin/songs.js',
            ],
            refresh: true,
        }),
    ],
});
