const path = require('path');
const fs = require('fs');

const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, { mode }) => ({
  ...defaultConfig,

  // Dynamically produce entries from the slotfills index file and all blocks.
  entry: () => {
    const blocks = defaultConfig.entry();

    return {
      ...blocks,
      ...fs
        .readdirSync('./entries')
        .reduce((acc, dirPath) => {
          acc[
            `entries-${dirPath}`
          ] = `./entries/${dirPath}`;
          return acc;
        }, {
          // All other custom entry points can be included here.
          'src-app': './src/js/app.ts',
        }),
    };
  },

  // Use different filenames for production and development builds for clarity.
  output: {
    clean: mode === 'production',
    filename: (pathData) => {
      const dirname = pathData.chunk.name;

      // Process all non-entries entries.
      if (!pathData.chunk.name.includes('entries-')) {
        return '[name].js';
      }

      const srcDirname = dirname.replace('entries-', '');
      return `${srcDirname}/index.js`;
    },
    path: path.join(__dirname, 'build'),
  },

  // Configure plugins.
  plugins: [
    ...defaultConfig.plugins,
    new CopyWebpackPlugin({
      patterns: [
        {
          from: '**/{index.php,*.css}',
          context: 'entries',
          noErrorOnMissing: true,
        },
      ],
    }),
    new MiniCssExtractPlugin({
      filename: (pathData) => {
        const dirname = pathData.chunk.name;
        // Process all blocks.
        if (!pathData.chunk.name.includes('entries-')) {
          return '[name].css';
        }

        const srcDirname = dirname.replace('entries-', '');
        return `${srcDirname}/index.css`;
      },
    }),
  ],

  // This webpack alias rule is needed at the root to ensure that the paths are resolved
  // using the custom alias defined below.
  resolve: {
    alias: {
      ...defaultConfig.resolve.alias,
      '@': path.resolve(__dirname),
    },
    extensions: ['.js', '.jsx', '.ts', '.tsx', '...'],
  },

  // Cache the generated webpack modules and chunks to improve build speed.
  // @see https://webpack.js.org/configuration/cache/
  cache: {
    ...defaultConfig.cache,
    type: 'filesystem',
  },
});
