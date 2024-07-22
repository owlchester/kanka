import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

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
        laravel([
            'resources/js/app.js',
            'resources/js/auth.js',
            'resources/js/location/map-v3.js',
            'resources/js/api.js',
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
            //'resources/js/timeline.js',
            'resources/js/profile.js',
            'resources/js/cookieconsent.js',
            'resources/js/relations.js',
            'resources/js/gallery.js',
            // 'resources/js/gallery/selection.js',
            'resources/js/history.js',
            'resources/js/editors/summernote.js',
            'resources/js/family-tree-vue.js',
            'resources/js/attributes-manager.js',
            'resources/js/campaigns/theme-builder.js',
            'resources/js/campaigns/import.js',

            'resources/sass/vendor.scss',
            'resources/sass/app.scss',
            'resources/sass/export.scss',
            'resources/sass/map-v3.scss',
            'resources/sass/subscription.scss',
            'resources/sass/front.scss',
            'resources/sass/auth.scss',
            'resources/sass/relations.scss',
            'resources/sass/dashboard.scss',
            'resources/sass/family-tree.scss',
            'resources/sass/settings.scss',
            'resources/sass/themes/dark.scss',
            'resources/sass/themes/midnight.scss',
            'resources/sass/tinymce.scss',
            'resources/sass/freyja/freyja.scss',
            'resources/sass/print/print.scss',

            'resources/js/vendor-final.js',
        ]),
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
    ],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler',
        },
    },
    build: {
        chunkSizeWarningLimit: 700,
    },
});
