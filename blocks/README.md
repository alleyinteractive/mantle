# Blocks Directory

Custom blocks in this directory can be created by running the `create-block` script. For understanding how blocks are architected, built, and enqueued refer to the [Block Editor Handbook | Anatomy of a Block](https://developer.wordpress.org/block-editor/getting-started/create-block/block-anatomy/).

## Scaffold a dynamic block with `@alleyinteractive/create-block`

1. In the root directory run `npm run create-block`
2. Choose whether to create a block in TypeScript or JavaScript.
3. Follow the prompts to create a custom block.

The `create-block` script will create the block files in a the block directory using the `slug` field entered from the prompts when scaffolding the block.

The script uses the [@alleyinteractive/create-block](https://github.com/alleyinteractive/alley-scripts/tree/main/packages/create-block) script with the `--namespace` flag for scaffolding block files with the plugin namespace of `create-wordpress-plugin`. See the `create-block` script in `package.json`.

For **dynmanic blocks** the following files will be generated:

```
blocks/
└───dynamic-block-slug
    │   block.json
    │   edit.jsx
    |   index.scss
    |   index.js
    |   index.php
    |   styles.scss
    |   render.php
```

The `index.php` contains the PHP block registration and will be autoloaded with the `load_scripts()` function once the block has been built by running `npm run build`.

Block attributes should be defined in the `block.json` file. [Learn more about block.json in the block editor handbook.](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/)

Running `npm run build` will compile the JavaScript and copy the PHP files to a directory in the `build` folder using `@wordpress/scripts`. The blocks will be enqueued via `block.json` after block registration. The block `index.php` file will be read by the `load_scripts()` function found in the `src/assets.php` file.
