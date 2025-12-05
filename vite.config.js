import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';


export default defineConfig({
    server: {
        //host: '172.18.0.6',
        hmr: {
            host: 'kanka.test',
        },
        watch: {
            ignored: [
                '**/bootstrap/**',
                '**/database/**',
                '**/docs/**',
                '**/lang/**',
                '**/node_modules/**',
                '**/public/**',
                '**/resources/api-docs/**',
                '**/resources/assets/**',
                '**/routes/**',
                '**/storage/**',
                '**/storage/debugbar/**',
                '**/tests/**',
                '**/vendor/**',
            ],
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/auth.js',
                'resources/js/location/map-v3.js',
                'resources/js/attributes.js',
                'resources/js/abilities.js',
                'resources/js/story.js',
                'resources/js/conversation.js',
                'resources/js/subscription.js',
                'resources/js/billing.js',
                'resources/js/forms/character.js',
                'resources/js/forms/calendar.js',
                'resources/js/dashboard.js',
                'resources/js/front.js',
                'resources/js/settings.js',
                'resources/js/profile.js',
                'resources/js/cookieconsent.js',
                'resources/js/relations.js',
                'resources/js/recovery/recovery.js',
                'resources/js/gallery/gallery.js',
                'resources/js/history.js',
                'resources/js/whiteboards.js',
                'resources/js/editors/summernote.js',
                //'resources/js/editors/tiptap.js',
                'resources/js/family-tree-vue.js',
                'resources/js/entities/explore.js',
                'resources/js/attributes-manager.js',
                'resources/js/campaigns/theme-builder.js',
                'resources/js/campaigns/import.js',

                'resources/css/app.css',
                'resources/css/vendors/tinymce.css',
                'resources/css/maps/maps.css',
                'resources/css/subscription.css',
                'resources/css/front.css',
                'resources/css/auth.css',
                'resources/css/relations.css',
                'resources/css/dashboard.css',
                'resources/css/families/tree.css',
                'resources/css/vendor.css',
                'resources/css/themes/dark.css',
                'resources/css/themes/midnight.css',

                'resources/css/print/print.css',

                'resources/js/vendor-final.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,

                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directory as expected.
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler',
        },
    },
});
