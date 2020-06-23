let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/payment';
const resourcePath = './platform/plugins/payment';

mix
    .js(resourcePath + '/resources/assets/js/payment.js', publicPath + '/js/payment.js')
    .copy(publicPath + '/js/payment.js', resourcePath + '/public/js')

    .js(resourcePath + '/resources/assets/js/payment-methods.js', publicPath + '/js/payment-methods.js')
    .copy(publicPath + '/js/payment-methods.js', resourcePath + '/public/js')

    .scripts([resourcePath + '/resources/assets/js/utils.js'], publicPath + '/js/utils.js')

    .sass(resourcePath + '/resources/assets/sass/payment.scss', publicPath + '/css')
    .copy(publicPath + '/css/payment.css', resourcePath + '/public/css')

    .sass(resourcePath + '/resources/assets/sass/payment-methods.scss', publicPath + '/css')
    .copy(publicPath + '/css/payment-methods.css', resourcePath + '/public/css');
