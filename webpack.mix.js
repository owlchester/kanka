let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

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
    //.js('resources/assets/js/location/map-v2.js', 'public/js/location')
    .js('resources/assets/js/api.js', 'public/js')
    .js('resources/assets/js/campaign.js', 'public/js')
    .js('resources/assets/js/entity', 'public/js')
    .js('resources/assets/js/organisation', 'public/js')
    .js('resources/assets/js/attributes', 'public/js')
    .js('resources/assets/js/conversation', 'public/js')
    .js('resources/assets/js/dashboard', 'public/js')
    .js('resources/assets/js/datagrids', 'public/js')
    //.js('resources/assets/js/front', 'public/js')
    .copy('vendor/blueimp/jquery-file-upload/js/jquery.fileupload.js', 'public/js')
    .copy('vendor/blueimp/jquery-file-upload/js/jquery.iframe-transport.js', 'public/js')
    .copy('vendor/blueimp/jquery-file-upload/js/vendor/jquery.ui.widget.js', 'public/js/vendor')
    .sass('resources/assets/sass/bootstrap.scss', 'public/css')
    .sass('resources/assets/sass/vendor.scss', 'public/css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/export.scss', 'public/css')
    .sass('resources/assets/sass/map.scss', 'public/css')
    .sass('resources/assets/sass/map-v2.scss', 'public/css')
    .sass('resources/assets/sass/conversation.scss', 'public/css')
    .sass('resources/assets/sass/front.scss', 'public/css')
    .sass('resources/assets/sass/dashboard.scss', 'public/css')
    .sass('resources/assets/sass/settings.scss', 'public/css')
    .sass('resources/assets/sass/themes/future.scss', 'public/css')
    .sass('resources/assets/sass/themes/dark.scss', 'public/css')
    .sass('resources/assets/sass/themes/midnight.scss', 'public/css')
    .sass('resources/assets/sass/tinymce.scss', 'public/css')
    // .options({
    //     processCssUrls: false,
    //     postCss:[
    //         tailwindcss('./tailwind.config.js')
    //     ]
    // })
    .version()
;