let mix = require('laravel-mix');
require('laravel-mix-brotli');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/character-map.js', 'public/js')
    .js('resources/assets/js/location/map.js', 'public/js/location')
    .js('resources/assets/js/location/map-v3.js', 'public/js/location')
    //.js('resources/assets/js/location/map-v2.js', 'public/js/location')
    .js('resources/assets/js/api.js', 'public/js')
    .js('resources/assets/js/campaign.js', 'public/js')
    .js('resources/assets/js/entity', 'public/js')
    .js('resources/assets/js/organisation', 'public/js')
    .js('resources/assets/js/attributes', 'public/js')
    .js('resources/assets/js/abilities', 'public/js')
    .js('resources/assets/js/conversation', 'public/js')
    .js('resources/assets/js/community-votes', 'public/js')
    .js('resources/assets/js/subscription', 'public/js')
    .js('resources/assets/js/billing', 'public/js')
    .js('resources/assets/js/dashboard', 'public/js')
    .js('resources/assets/js/datagrids', 'public/js')
    .js('resources/assets/js/lfgm', 'public/js')
    .js('resources/assets/js/front', 'public/js')
    .js('resources/assets/js/timeline', 'public/js')
    .js('resources/assets/js/profile', 'public/js')
    .js('resources/assets/js/relations', 'public/js')
    .js('resources/assets/js/editors/summernote', 'public/js/editors')
    //.js('resources/assets/js/front', 'public/js')
    .copy('vendor/blueimp/jquery-file-upload/js/jquery.fileupload.js', 'public/js')
    .copy('vendor/blueimp/jquery-file-upload/js/jquery.iframe-transport.js', 'public/js')
    .copy('vendor/blueimp/jquery-file-upload/js/vendor/jquery.ui.widget.js', 'public/js/vendor')
    .sass('resources/assets/sass/bootstrap.scss', 'public/css')
    .sass('resources/assets/sass/vendor.scss', 'public/css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/app-rtl.scss', 'public/css')
    .sass('resources/assets/sass/abilities.scss', 'public/css')
    .sass('resources/assets/sass/export.scss', 'public/css')
    .sass('resources/assets/sass/map.scss', 'public/css')
    .sass('resources/assets/sass/map-v2.scss', 'public/css')
    .sass('resources/assets/sass/map-v3.scss', 'public/css')
    .sass('resources/assets/sass/subscription.scss', 'public/css')
    .sass('resources/assets/sass/conversation.scss', 'public/css')
    .sass('resources/assets/sass/front.scss', 'public/css')
    .sass('resources/assets/sass/auth.scss', 'public/css')
    .sass('resources/assets/sass/front-rtl.scss', 'public/css')
    .sass('resources/assets/sass/community-votes.scss', 'public/css')
    .sass('resources/assets/sass/relations.scss', 'public/css')
    .sass('resources/assets/sass/dashboard.scss', 'public/css')
    .sass('resources/assets/sass/settings.scss', 'public/css')
    .sass('resources/assets/sass/themes/future.scss', 'public/css')
    .sass('resources/assets/sass/themes/dark.scss', 'public/css')
    .sass('resources/assets/sass/themes/midnight.scss', 'public/css')
    .sass('resources/assets/sass/tinymce.scss', 'public/css')
    .sass('resources/assets/sass/freyja/freyja.scss', 'public/css')
    .brotli({
        enabled: mix.inProduction(),
        asset: '[path].br[query]',
        test: /\.(js|css|html|svg)$/,
        threshold: 10240,
        minRatio: 0.8
    })
    // .options({
    //     processCssUrls: false,
    //     postCss:[
    //         tailwindcss('./tailwind.config.js')
    //     ]
    // })
    .version()
;
