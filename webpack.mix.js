let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
//require('laravel-mix-brotli');

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
mix.webpackConfig({
    stats: {
        children: true,
    },
});

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/auth.js', 'public/js')
    .js('resources/assets/js/ajax-subforms.js', 'public/js')
    .js('resources/assets/js/location/map.js', 'public/js/location')
    .js('resources/assets/js/location/map-v3.js', 'public/js/location')
    .js('resources/assets/js/api.js', 'public/js')
    .js('resources/assets/js/attributes', 'public/js')
    .js('resources/assets/js/abilities', 'public/js')
    .js('resources/assets/js/story', 'public/js')
    .js('resources/assets/js/conversation', 'public/js')
    .js('resources/assets/js/subscription', 'public/js')
    .js('resources/assets/js/billing', 'public/js')
    .js('resources/assets/js/forms/character', 'public/js/forms')
    .js('resources/assets/js/forms/calendar', 'public/js/forms')
    .js('resources/assets/js/dashboard', 'public/js')
    .js('resources/assets/js/front', 'public/js')
    .js('resources/assets/js/settings', 'public/js')
    .js('resources/assets/js/timeline', 'public/js')
    .js('resources/assets/js/profile', 'public/js')
    .js('resources/assets/js/relations', 'public/js')
    .js('resources/assets/js/gallery', 'public/js')
    .js('resources/assets/js/history', 'public/js')
    .js('resources/assets/js/editors/summernote', 'public/js/editors')
    .sourceMaps(true, 'source-map')
    .vue()
    //.js('resources/assets/js/front', 'public/js')
    .copy('vendor/blueimp/jquery-file-upload/js/jquery.fileupload.js', 'public/js')
    .copy('vendor/blueimp/jquery-file-upload/js/jquery.iframe-transport.js', 'public/js')
    .copy('vendor/blueimp/jquery-file-upload/js/vendor/jquery.ui.widget.js', 'public/js/vendor')
    //.sass('resources/assets/sass/bootstrap.scss', 'public/css')
    .sass('resources/assets/sass/vendor.scss', 'public/css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/abilities.scss', 'public/css')
    .sass('resources/assets/sass/story.scss', 'public/css')
    .sass('resources/assets/sass/assets.scss', 'public/css')
    .sass('resources/assets/sass/export.scss', 'public/css')
    .sass('resources/assets/sass/map.scss', 'public/css')
    .sass('resources/assets/sass/map-v3.scss', 'public/css')
    .sass('resources/assets/sass/subscription.scss', 'public/css')
    .sass('resources/assets/sass/gallery.scss', 'public/css')
    .sass('resources/assets/sass/front.scss', 'public/css')
    .sass('resources/assets/sass/auth.scss', 'public/css')
    .sass('resources/assets/sass/front/critical.scss', 'public/css/front')
    .sass('resources/assets/sass/relations.scss', 'public/css')
    .sass('resources/assets/sass/dashboard.scss', 'public/css')
    .sass('resources/assets/sass/settings.scss', 'public/css')
    .sass('resources/assets/sass/themes/dark.scss', 'public/css')
    .sass('resources/assets/sass/themes/midnight.scss', 'public/css')
    .sass('resources/assets/sass/tinymce.scss', 'public/css')
    .sass('resources/assets/sass/freyja/freyja.scss', 'public/css')
    .sass('resources/assets/sass/print/print.scss', 'public/css')
    /*.sass('resources/assets/sass/tailwind.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })*/

    /*.postCss("resources/assets/css/tailwind.css", "public/css", [
        require("tailwindcss"),
    ])*/
    //.brotli({
    //    enabled: mix.inProduction(),
    //    asset: '[path].br[query]',
    //    test: /\.(js|css|html|svg)$/,
    //    threshold: 10240,
    //    minRatio: 0.8
    //})
    // .options({
    //     processCssUrls: false,
    //     postCss:[
    //         tailwindcss('./tailwind.config.js')
    //     ]
    // })
    .options({
        processCssUrls: false
    })
    .version()
;

/*mix.postCss("resources/assets/css/tailwind.css", "public/css", [
    require("tailwindcss"),
]);*/

/*mix.setPublicPath('./public/js/').extract([
    'lodash',
    'bootstrap',
    'bootstrap-sass',
    'admin-lte',
    'select2',
    'bootstrap-datepicker',
    'eonasdan-bootstrap-datetimepicker',
    'spectrum-colorpicker',
    'jquery-ui/ui/widgets/draggable',
    'jquery-ui/ui/widgets/sortable',
    'axios',
], 'vendor.js');*/

