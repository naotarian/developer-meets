const mix = require('laravel-mix');
const glob = require("glob");
mix.webpackConfig({
  module: {
    rules: [
      {
        // ローダーの処理対象ファイル
        test: /\.js$/,
        // 変換する前にコード検証する
        enforce: 'pre',
        // 処理対象のファイルに対する処理を指定
        exclude: /node_modules/,
        loader: 'eslint-loader',
        options: {
          fix: false
        }
      }
    ]
  }
})
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
  mix.js(file_path, 'public/js/components/Atoms/').react().version()
});
// build Molecules/*js
glob.sync('resources/js/components/Molecules/*.js').map((file_path) => {
  mix.js(file_path, 'public/js/components/Molecules/').react().version()
});
// build Organisms/*js
glob.sync('resources/js/components/Organisms/*.js').map((file_path) => {
  mix.js(file_path, 'public/js/components/Organisms/').react().version()
});
// build Templates/*js
glob.sync('resources/js/components/Templates/*.js').map((file_path) => {
  mix.js(file_path, 'public/js/components/Templates/').react().version()
});
// build Pages/*js
glob.sync('resources/js/components/Pages/*.js').map((file_path) => {
  mix.js(file_path, 'public/js/components/Pages/').react().version()
});
// build *js
glob.sync('resources/js/components/*.js').map((file_path) => {
  mix.js(file_path, 'public/js/').react().version()
});
