const mix = require('laravel-mix');
const glob = require("glob");

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


// build Atoms/*js
glob.sync('resources/js/components/Atoms/*.js').map((file_path) => {
  mix.react(file_path, 'public/js/components/Atoms/').version()
});
// build Molecules/*js
glob.sync('resources/js/components/Molecules/*.js').map((file_path) => {
  mix.react(file_path, 'public/js/components/Molecules/').version()
});
// build Organisms/*js
glob.sync('resources/js/components/Organisms/*.js').map((file_path) => {
  mix.react(file_path, 'public/js/components/Organisms/').version()
});
// build Templates/*js
glob.sync('resources/js/components/Templates/*.js').map((file_path) => {
  mix.react(file_path, 'public/js/components/Templates/').version()
});
// build Pages/*js
glob.sync('resources/js/components/Pages/*.js').map((file_path) => {
  mix.react(file_path, 'public/js/components/Pages/').version()
});
// build *js
glob.sync('resources/js/components/*.js').map((file_path) => {
  mix.react(file_path, 'public/js/').version()
});
