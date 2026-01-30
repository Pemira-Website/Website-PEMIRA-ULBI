import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Minify output
        minify: 'esbuild',
        // Optimize CSS
        cssMinify: true,
        // Better chunk splitting
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs'],
                },
            },
        },
        // Reduce chunk size warnings threshold
        chunkSizeWarningLimit: 500,
    },
});

