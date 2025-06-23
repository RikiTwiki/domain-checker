// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    resolve: {
        alias: { vue: 'vue/dist/vue.esm-bundler.js' },
    },
    plugins: [
        laravel({ input: [
                'resources/js/app.js',
            ], refresh: true }),
        vue(),
    ],
    server: {
        host: 'localhost',
        port: 5173,
        proxy: {
            '/api': {
                target: 'http://127.0.0.1:8000',
                changeOrigin: true,
                secure: false,
            },
        },
    },
});
