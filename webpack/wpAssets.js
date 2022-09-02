/* eslint-disable import/no-extraneous-dependencies, max-len */
const fs = require('fs');
const path = require('path');
const chalk = require('chalk');

/**
 * Build JSON object containing a global hash and map of asset names to the output filename of that asset.
 * Assets are organized by entry point.
 *
 * @return {string} JSON object containg asset name => filename mapping.
 */
module.exports = (stats, opts) => {
  const {
    options: {
      mode, // 'development' || 'production'
    },
    chunks,
  } = opts.compiler;

  const {
    assetsByChunkName: assets,
    hash: compilerHash,
  } = stats;

  /**
   * Format chunks' contentHash object.
   *
   * @return {object} An object of css/js hashes for each entry.
   */
  const formattedChunkHashes = Array.from(chunks).reduce((chunkAcc, chunk) => {
    const { name, contentHash } = chunk;

    const { css, js } = Object.keys(contentHash).reduce((hasAcc, type) => {
      if (type.includes('css')) {
        // Currently the key is 'css/mini-extract'
        return { ...hasAcc, css: contentHash[type] };
      }

      if (type.includes('javascript')) {
        // Currently the key is 'javascript'
        return { ...hasAcc, js: contentHash[type] };
      }

      return hasAcc;
    }, {});

    return { ...chunkAcc, [name]: { css, js } };
  }, {});

  /**
   * Used to make sure values in the asset JSON don't contain unexpected characters.
   * This should prevent any PHP slipping through, which would be dangerous since
   * we're `include`ing the resulting JSON file.
   *
   * NOTE: This is a negated character set because we're looking for
   *  anything that _isn't_ one of these characters.
   */
  const hasInvalidCharacters = (value) => {
    const assetRegex = new RegExp('[^\\/\\.\\-_a-zA-Z0-9]', 'g');

    if (assetRegex.test(value)) {
      // eslint-disable-next-line max-len, no-console
      console.log(chalk.red(`Attempted to write invalid value '${value}' to static asset JSON manifest. All JSON values must match ${assetRegex}`));
      return true;
    }

    return false;
  };

  /**
   * Collect all assets for a specific entry point into an object.
   *
   * @param {object} assetList - relative asset paths for a specific entry point's file types.
   */
  const getAssets = (assetList, entryHashReference) => assetList.reduce((assetAcc, outputPath) => {
    const fileInfo = path.parse(outputPath);
    const ext = fileInfo.ext.replace('.', '');

    // Validate key and value
    if (
      hasInvalidCharacters(ext)
      || hasInvalidCharacters(outputPath)
    ) {
      return assetAcc;
    }

    if (ext !== 'map') {
      const hash = entryHashReference[ext] || compilerHash;
      return { ...assetAcc, [ext]: { path: outputPath, hash } };
    }

    return assetAcc;
  }, {});

  // Loop through entries
  const entryMap = Object.keys(assets).reduce((entryAcc, entryName) => {
    // Validate entry name
    if (hasInvalidCharacters(entryName)) {
      return entryAcc;
    }

    // Make sure it's an array
    const assetList = [].concat(assets[entryName]);

    // Loop through assets
    return { ...entryAcc, [entryName]: getAssets(assetList, formattedChunkHashes[entryName]) };
  }, { hash: compilerHash, mode });

  const manifestJSON = JSON.stringify(entryMap);

  // Write out asset manifest explicitly or else it'll be served from localhost, where wp can't access it
  if (mode === 'development') {
    const assetMap = path.join(__dirname, '../build/assetMap.json');
    const assetMapPath = path.dirname(assetMap);

    // Create build directory if it doesn't exist, as may be the case on first run.
    if (!fs.existsSync(assetMapPath)) {
      try {
        fs.mkdirSync(assetMapPath, { recursive: true });
      } catch (error) {
        console.error(`Error creating the build directory: ${error}`); // eslint-disable-line no-console
        // die.
        process.exit(1);
      }
    }

    fs.writeFileSync(
      assetMap,
      manifestJSON,
      (error) => {
        console.error(`Error writing assetMap: ${error}`); // eslint-disable-line no-console
        // die.
        process.exit(1);
      },
    );
  }

  return manifestJSON;
};
