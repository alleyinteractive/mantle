/* eslint-disable no-console */
const { execSync } = require('child_process');
const { readFile } = require('fs').promises;
const https = require('https');
const path = require('path');

// Ensure the version was passed.
if (process.argv.length !== 3) {
  console.log('Usage: npm run update-dependencies WPVERSION');
  console.log('Example: npm run update-dependencies 5.9.3');
  process.exit(1);
}

/**
 * A simple wrapper for https.get that lets it be used with async/await.
 * @param {string} url - The URL to fetch.
 * @returns {Promise<string>} A Promise that resolves to a string.
 */
const get = (url) => new Promise((resolve, reject) => {
  https.get(url, (res) => {
    const data = [];
    res.on('data', (chunk) => data.push(chunk));
    res.on('end', () => resolve(Buffer.concat(data).toString()));
  }).on('error', reject);
});

(async () => {
  console.log(`Fetching information about dependencies for WP ${process.argv[2]}`);
  const wpPackageJSON = JSON.parse(await get(`https://raw.githubusercontent.com/WordPress/wordpress-develop/${process.argv[2]}/package.json`));

  // Get information about our package dependencies.
  const packageJSON = JSON.parse(await readFile(path.join(__dirname, '../package.json')));

  // Build a list of package dependencies to potentially update.
  const packageList = {
    dependencies: Object.keys(packageJSON.dependencies).reduce((acc, item) => {
      if (item.includes('@wordpress/')) {
        acc.push(item);
      }
      return acc;
    }, [
      'lodash',
      'moment',
      'react',
      'react-dom',
    ]),
    devDependencies: [
      '@wordpress/dependency-extraction-webpack-plugin',
    ],
  };

  // Loop over dependencies and update each, as necessary.
  // eslint-disable-next-line guard-for-in
  for (const dependencyType in packageList) {
    const operator = dependencyType === 'devDependencies' ? '--save-dev' : '--save --save-exact';
    const prefix = dependencyType === 'devDependencies' ? '^' : '';
    for (const dependency of packageList[dependencyType]) {
      // Compare versions to determine whether to update or skip.
      const oldVersion = `${packageJSON[dependencyType][dependency]}`;
      const newVersion = `${prefix}${wpPackageJSON[dependencyType][dependency]}`;
      if (oldVersion === newVersion && newVersion !== undefined) {
        console.log(`${dependency} at correct version. Skipping.`);
      } else {
        console.log(`Updating ${dependency} from version ${oldVersion} to version ${newVersion}`);
        execSync(`npm install ${operator} --legacy-peer-deps ${dependency}@${newVersion}`);
      }
    }
  }
})();
