const mix = require('laravel-mix');

require('laravel-mix-polyfill');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Mantle application
 |
 */

// Let mix know Mantle is in a public path.
mix.setPublicPath(process.env.APP_BUILD_PATH || 'build');

// Define the entries you need built with mix!
mix
  .js('src/js/app.js', 'build/js')
  .sass('src/scss/app.scss', 'build/css');

mix.polyfill({
  enabled: true,
  useBuiltIns: 'usage',
  targets: 'firefox 50, IE 11',
});

if (mix.inProduction()) {
  mix.version();
} else {
  mix.sourceMaps();
}
