import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 'resources/css/app.css',
                // 'resources/js/app.js',
                'resources/scss/**/*.scss',
                'resources/css/**/*.css',
            ],
            refresh: true,
        }),
    ],
    // @see https://readouble.com/laravel/11.x/en/vite.html#running-the-development-server-in-sail-on-wsl2:~:text=run%20dev%20command.-,Running%20the%20Development%20Server%20in%20Sail%20on%20WSL2,-When%20running%20the
    server: {
        hmr: {
            host: 'localhost',
        },
        // @see https://vite.dev/config/server-options.html#server-watch
        watch: {
            usePolling: true
        }
    },
});
