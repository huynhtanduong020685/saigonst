let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/real-estate';
const resourcePath = './platform/plugins/real-estate';

mix
    .js(resourcePath + '/resources/assets/js/real-estate.js', publicPath + '/js')
    .copy(publicPath + '/js/real-estate.js', resourcePath + '/public/js')

    .sass(resourcePath + '/resources/assets/sass/real-estate.scss', publicPath + '/css')
    .copy(publicPath + '/css/real-estate.css', resourcePath + '/public/css')

.js(resourcePath + '/resources/assets/js/currencies.js', publicPath + '/js')
    .copy(publicPath + '/js/currencies.js', resourcePath + '/public/js')

    .sass(resourcePath + '/resources/assets/sass/currencies.scss', publicPath + '/css')
    .copy(publicPath + '/css/currencies.css', resourcePath + '/public/css');
