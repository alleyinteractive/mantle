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
   */
  register(
    entryPath,
    {
      prefix = null
    } = {},
  ) {
    this.entryPath = entryPath;
    this.prefix = prefix || path.basename(entryPath);

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
      .sync(`${rootPath}/${this.entryPath}/**/index.js*`)
      .reduce((acc, item) => {
        const entry = item
          .replace(`${rootPath}/${this.entryPath}/`, '')
          .replace(/\/index\.jsx?/, '');

        acc[`${this.prefix}-${entry}`] = item;
        return acc;
      }, {});

    // Automatically load the entries in the 'entries' directory.
    Object.keys(entries).forEach((entry) => {
      mix.js(entries[entry], `build/${entry}.js`);
    });
  }
}

mix.extend('discover', new DiscoverEntries());
