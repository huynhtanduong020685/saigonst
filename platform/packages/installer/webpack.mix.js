let mix = require('laravel-mix');

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

const resourcePath = 'platform/packages/installer';
const publicPath = 'public/vendor/core/packages/installer';

mix
    .sass(resourcePath + '/resources/assets/sass/style.scss', publicPath + '/css')
    .copy(publicPath + '/css/style.css', resourcePath + '/public/css');

