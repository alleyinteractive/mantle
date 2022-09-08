const mix = require('laravel-mix');
const fs = require('fs');

require("@tinypixelco/laravel-mix-wp-blocks");
require('laravel-mix-polyfill');

function discover(dir, type) {
  let jsFiles = []
  fs.readdirSync(dir).forEach(file => {
      let fileName = `${dir}/${file}`
      if(fs.statSync(fileName).isFile()) {
          if (fileName.endsWith(type)) {
              jsFiles.push(fileName)
          }
      } else {
          jsFiles = jsFiles.concat(discover(fileName, type))
      }
  })
  return jsFiles
}

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

const blocksDir = 'src/js/blocks';

discover(blocksDir, 'index.js').forEach(file => {
  mix.block(file, `build/blocks/${file.substr( file.indexOf( blocksDir ) + blocksDir.length )}`,{
    outputFormat: 'json'
  });
});

discover(blocksDir, 'index.jsx').forEach(file => {
  mix.block(file, `build/blocks/${file.substr( file.indexOf( blocksDir ) + blocksDir.length ).replace( 'jsx', 'js' )}`,{
    outputFormat: 'json'
  });
});

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
