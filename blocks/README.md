# Blocks Directory

Custom blocks in this directory can be created by running the `create-block` script. For understanding how blocks are architected, built, and enqueued refer to the [Block Editor Handbook | Anatomy of a Block](https://developer.wordpress.org/block-editor/getting-started/create-block/block-anatomy/).

## Scaffold a block with `create-block`

1. In the root directory run `npm run create-block`
2. Follow the prompts to create a custom block.

There are 2 variants of blocks which you can create:

1. `static` - scaffolds a [basic block](https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/writing-your-first-block-type/) with edit.js and save.js functions.
2. `dynamic` - scaffolds a [dynamic block](https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/creating-dynamic-blocks/) with a `render.php` file for server side output on the front end.

The `create-block` script will create the block files in a the block directory using the `slug` field entered from the prompts when scaffolding the block.

The script uses the [@wordpress/create-block](https://github.com/WordPress/gutenberg/tree/trunk/packages/create-block#create-block) script with the `--no-plugin` flag for scaffolding block files only, and the `--template` flag setting the block template files to be scaffolded. See the `create-block` script in `package.json`.

You can also scaffold a quick block by navigating to the blocks directory in your terminal and run the following command by passing in a slug for quick static block scaffolding:
```
npx @wordpress/create-block my-slug --template ../bin/create-block --no-plugin
```

For **static blocks** the following files will be generated:

```
blocks/
└───static-block-slug
    │   block.json
    │   edit.jsx
    |   index.scss
    |   index.js
    |   index.php
    |   save.jsx
    |   styles.scss
```

For **dynamic blocks** the following files will be generated:

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

Running `npm run build` will compile the JavaScript and copy the PHP files to a directory in the `build` folder using `@wordpress/scripts`. The blocks will be enqueued via `block.json` after block registration. The block `index.php` file will be read by the `load_scripts()` function found in the `function.php` file.

## Customize the block scaffolding templates

The `bin/create-block` script and associated `.mustache` files replace default files included in the `@wordpress/create-block` script for scaffolding blocks. To learn more about external project templates and to customize different variations of scaffolded blocks refer to the [External Project Templates documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/packages-create-block-external-template/) in the block editor handbook.
