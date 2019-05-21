var mix = require('laravel-mix');

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

mix.js(['resources/assets/js/app.js',
    'resources/assets/js/calculaParcela.js',
    'resources/assets/js/controlaSelecaoPacotes.js',
    'resources/assets/js/mascaraCampos.js',
    'resources/assets/js/Funcoes.js',
    'resources/assets/js/plugins.js',
    'resources/assets/js/plugins/uiTables.js'
], 'public/js');

// mix.styles([
//     'resources/assets/sass/css/css/select2.js',
//     'resources/assets/sass/css/css/select2.min.js'
// ], 'public/css/all.css');

// mix.sass(['resources/assets/sass/chosen.css'
// ], 'public/css');

