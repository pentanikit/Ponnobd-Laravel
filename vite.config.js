import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'public/frontend/assets/owl-carousel/owl.carousel.min.css',
                'public/frontend/assets/owl-carousel/owl.theme.default.min.css',
                'public/frontend/assets/bootstrap/css/bootstrap.min.css',
                'public/frontend/assets/css/style.css',
                'public/frontend/assets/js/vendors.js',
                'public/frontend/assets/js/app.js',
                'public/frontend/assets/js/theme.js',
            ],
            refresh: true,
        }),
    ],
});
