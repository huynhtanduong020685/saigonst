let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/vendor';
const resourcePath = './platform/plugins/vendor';

mix
    .js(resourcePath + '/resources/assets/js/vendor-admin.js', publicPath + '/js')
    .copy(publicPath + '/js/vendor-admin.js', resourcePath + '/public/js')

    .sass(resourcePath + '/resources/assets/sass/vendor.scss', publicPath + '/css')
    .copy(publicPath + '/css/vendor.css', resourcePath + '/public/css');

mix
    .js(resourcePath + '/resources/assets/js/app.js', publicPath + '/js')
    .copy(publicPath + '/js/app.js', resourcePath + '/public/js')
    .sass(resourcePath + '/resources/assets/sass/app.scss', publicPath + '/css')
    .copy(publicPath + '/css/app.css', resourcePath + '/public/css');
