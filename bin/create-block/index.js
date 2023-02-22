const path = require('path');

/**
 * Custom Variables and templates for scaffolding blocks.
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/create-block/docs/external-template.md#external-project-templates
 */
module.exports = {
  defaultValues: {
    namespace: 'create-wordpress-plugin',
    plugin: false,
    description: '',
    dashicon: 'palmtree',
    category: 'widgets',
    editorScript: 'file:index.ts',
    editorStyle: 'file:index.css',
    style: ['file:style-index.css'],
  },
  variants: {
    static: {},
    'static-javascript': {
      blockTemplatesPath: path.join(__dirname, 'templates', 'block', 'javascript'),
    },
    dynamic: {
      render: 'file:render.php',
    },
    'dynamic-javascript': {
      blockTemplatesPath: path.join(__dirname, 'templates', 'block', 'javascript'),
      render: 'file:render.php',
    },
  },
  blockTemplatesPath: path.join(__dirname, 'templates', 'block', 'typescript'),
};
