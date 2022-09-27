/** @type {import('ts-jest/dist/types').InitialOptionsTsJest} */
module.exports = {
  moduleNameMapper: {
    '^@/(.*)$': '<rootDir>/$1',
  },
  modulePathIgnorePatterns: [
    ".buddy-tests",
  ],
  preset: 'ts-jest/presets/js-with-ts',
  testEnvironment: 'jsdom',
  transformIgnorePatterns: [],
  globals: {
    'ts-jest': {
      isolatedModules: true,
      tsconfig: './tsconfig.json',
    },
  },
};
