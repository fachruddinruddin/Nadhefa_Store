import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss',
                'resources/views/themes/nadhefa/assets/js/main.js',
                'resources/views/themes/nadhefa/assets/css/main.css', 
                'resources/views/themes/nadhefa/assets/plugins/jqueryui/jquery-ui.css',
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                quietDeps: true,
            }
        }
    }
});
