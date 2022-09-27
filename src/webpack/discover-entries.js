const glob = require('glob');
const mix = require('laravel-mix');
const path = require('path');
const fs = require('fs');

/**
 * Define the root path to the project.
 *
 * @var {String}
 */
const rootPath = path.resolve(__dirname, '../..');

/**
 * Extension class to discover and register entries in a specified directory.
 */
class DiscoverEntries {
  /**
   * Register the plugin.
   *
   * @param {String} entryPath Entry path to discover.
   * @param {Object} options Options for the plugin.
   * @param {String} options.prefix Folder prefix to use for the built path, optional.
   * @param {String} options.type Type of asset to discover (js/ts/block), optional.
   */
  register(
    entryPath,
    {
      prefix = null,
      type = 'ts',
    } = {},
  ) {
    this.entryPath = entryPath;
    this.prefix = prefix || path.basename(entryPath);
    this.type = type;

    // Check if the folder exists.
    if (!fs.existsSync(`${rootPath}/${entryPath}`)) {
      throw new Error(`The folder to discover from does not exist: [${rootPath}/${entryPath}]`);
    }

    this.discoverEntries();
  }

  /**
   * Discover entries in the specified directory.
   */
  discoverEntries() {
    const entries = glob
      .sync(`${rootPath}/${this.entryPath}/**/index.?(j|t)s*`)
      .reduce((acc, item) => {
        const entry = item
          .replace(`${rootPath}/${this.entryPath}/`, '')
          .replace(/\/index\.(j|t)sx?/, '');

        acc[`${this.prefix}-${entry}`] = item;
        return acc;
      }, {});

    // Automatically load the entries in the 'entries' directory.
    Object.keys(entries).forEach((entry) => {
      if ('undefined' === typeof mix[this.type]) {
        throw new Error(`The method of registering of asset to discover is not supported: [${this.type}]`);
      }

      mix[this.type](entries[entry], `build/${entry}.js`);
    });
  }
}

mix.extend('discover', new DiscoverEntries());
