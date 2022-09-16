const mix = require('laravel-mix');
const path = require('path');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');

require('laravel-mix-polyfill');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Mantle application
 |
 | https://laravel-mix.com/docs/6.0/
 |
 */

/*
| --------------------------------------------------------------------------
| Entries to be built
| --------------------------------------------------------------------------
|
| Define the entries you need built with mix.
|
*/
mix
  .js('src/js/app.js', 'build/js')
  .sass('src/scss/app.scss', 'build/css');

/*
| --------------------------------------------------------------------------
| Alias Paths
| --------------------------------------------------------------------------
|
| Define alias paths that make it easier to reference files in your application. By default,
| @ is registered to reference the root of your application.
|
*/
mix.alias({
  '@': path.join(__dirname),
});

/*
| --------------------------------------------------------------------------
| Public Path
| --------------------------------------------------------------------------
|
| Define the public path used by the build process.
|
*/
mix.setPublicPath(process.env.APP_BUILD_PATH || 'build');

/*
| --------------------------------------------------------------------------
| Polyfill
| --------------------------------------------------------------------------
|
| A Laravel Mix extension to include polyfills by using Babel, core-js, and regenerator-runtime.
|
| https://laravel-mix.com/extensions/polyfill
|
*/
mix.polyfill({
  enabled: true,
  useBuiltIns: 'usage',
  targets: 'defaults, not IE 11',
});

/*
| --------------------------------------------------------------------------
| Webpack Plugins
| --------------------------------------------------------------------------
|
| Here you may register any webpack plugins that your application requires. By
| default the @wordpress/dependency-extraction-webpack-plugin is registered to
| improve performance with Gutenberg.
|
*/
mix.webpackConfig((webpack) => ({
  plugins: [
    new DependencyExtractionWebpackPlugin({ useDefaults: true }),
  ],
}));

if (mix.inProduction()) {
  mix.version();
} else {
  mix.sourceMaps();
}
