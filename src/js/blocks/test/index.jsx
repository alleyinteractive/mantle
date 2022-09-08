// Import WordPress block dependencies.
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import attributes from './attributes.json';
import edit from './edit';

/* eslint-disable quotes */

registerBlockType(
  'app/test',
  {
    attributes,
    apiVersion: 2,
    category: 'widgets',
    description: __(
      'This is an example block, written for Mantle.',
      'mantle',
    ),
    edit,
    icon: 'embed-generic',
    keywords: [
      __('test', 'mantle'),
    ],
    title: __('Example Block', 'mantle'),
  }
);
