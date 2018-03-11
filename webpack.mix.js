const { mix } = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const webpack = require("webpack");
require('laravel-mix-purgecss');

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
    .extract(['axios', 'vue', 'vuex', 'marked', 'moment', 'vue-router'])
    .postCss('resources/assets/css/tailwind.css', 'public/css', [
      tailwindcss('./tailwind.js'),
    ])
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/app_v4.scss', 'public/css')
    .version()
    .purgeCss({
        enabled: mix.inProduction(),
    });




mix.webpackConfig({
    plugins: [
        new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /en/)
       // new OfflinePlugin()
    ]
});
