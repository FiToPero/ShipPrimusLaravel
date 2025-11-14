import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: '0.0.0.0',  // Asegura que Vite esté disponible en todo el contenedor
        port: 5173,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,  // Usa polling para vigilar los cambios en archivos dentro del contenedor
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
