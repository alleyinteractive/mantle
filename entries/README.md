# Entry Points Directory

This is the directory where `alley-build` will detect entry point directories that are not blocks. These entries can be slotfills or webpack entry points.

Each entry point should contain an `index.ts` file that will be used as the entry point for webpack. The entry point directory should also contain any other files that are needed for the entry point to work.

## Entry point directory structure
```
entries/
└── example/
    ├── index.ts
    ├── file1.ts
    └── file2.ts
```
The above example will create a webpack entry point called `example` that will be built to `build/example/index.js`.

The entry point can also include php files that will be copied to the build directory. This is useful for slotfills or other entries where script registration and enqueueing can be authored alongside the script itself.

```
entries/
└── example/
    ├── index.ts
    ├── file1.ts
    ├── file2.ts
    └── index.php
```

## Create a new entry point or slotfill
The [`create-entry`](https://github.com/alleyinteractive/alley-scripts/tree/main/packages/create-entry#create-entry-point) command can be used to create a new entry point directory. The command will prompt for the name of the entry point and will create the directory and files needed for the entry point to work.

This project already includes the necessary scripts to create a new entry point and slotfill. To create a new entry point, run the following command:

```bash
npm run create-entry
```
To create a slotfill entry point, use the `--slotfill` flag:
```bash
npm run create-slotfill
```

Each of these commands will prompt for the name of the entry point and will create the directory and files needed for the entry point or slotfill to work. Run the build command to build the new entry points or slotfills.

Read more about the `create-entry` command [here](https://github.com/alleyinteractive/alley-scripts/tree/main/packages/create-entry#create-entry-point) or run the command with the `--help` flag for more information.

```bash
npx @alleyinteractive/create-entry -h
```
