import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',    // default
                'resources/css/user.css',   // user layout
                'resources/css/admin.css',  // admin layout
                'resources/js/app.js'       // JS
            ],
            refresh: true,
        }),
    ],
});