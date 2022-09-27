const glob = require('glob');
const mix = require('laravel-mix');
const path = require('path');

require('laravel-mix-polyfill');
require('@tinypixelco/laravel-mix-wp-blocks');
require('./src/webpack/discover-entries');

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
| Public Path
| --------------------------------------------------------------------------
|
| Define the public path used by the build process. This must be called before
| compiling any entries.
|
*/

mix.setPublicPath(process.env.APP_BUILD_PATH || 'build');

/*
| --------------------------------------------------------------------------
| Discover Entries
| --------------------------------------------------------------------------
|
| Discover entries in the 'entries' directory and automatically compile them.
| index.js files that live within a folder inside entries will automatically be
| compiled.
|
| Discover index.js/index.ts files within a specific directory (uses Typescript
| by default):
|
|   mix.discover('entries');
|
| Discover WordPress blocks within /blocks/:
|
|   mix.discover('blocks', { type: 'block' });
*/

mix.discover('entries');
mix.discover('blocks', { type: 'block' });

/*
| --------------------------------------------------------------------------
| Entries to be built
| --------------------------------------------------------------------------
|
| Define the entries you need built with mix.
|
*/

mix
  .js('src/js/app.js', 'build')
  .js('slotfills/index.js', 'build/slotfills.js')
  .sass('src/scss/app.scss', 'build');

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

if (mix.inProduction()) {
  mix.version();
} else {
  mix.sourceMaps();
}
