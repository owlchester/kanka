var webpack = require('webpack');
var path = require('path');

module.exports = {
    entry: './main.js',
    output: {
        filename: './dist/bundle.js'
    },
    resolve: {
        alias: {
            'jquery': path.join(__dirname, 'node_modules/jquery/dist/jquery')
        }
    },
    module: {
        loaders: [
            {
                test: require.resolve('tinymce/tinymce'),
                loaders: [
                  'imports?this=>window',
                  'exports?window.tinymce'
                ]
              }
        ]
    },
    debug: true,
    watch: false
};