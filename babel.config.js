/**
 * This babel config is used by Jest to ensure that tests
 * will run correctly in Typescript and JavaScript files.
 *
 * Jest supports TypeScript, via Babel.
 *
 * @see https://jestjs.io/docs/getting-started#using-typescript
 */
module.exports = {
  presets: [
    '@babel/preset-env',
    '@wordpress/babel-preset-default',
  ],
};
