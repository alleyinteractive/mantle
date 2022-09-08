import { __ } from '@wordpress/i18n';
import React from 'react';
import PropTypes from 'prop-types';

const Edit = ({
  setAttributes,
}) => (
  <div>{__('Get going!', '<%= $domain %>')}</div>
);

Edit.propTypes = {
  setAttributes: PropTypes.func.isRequired,
};

export default Edit;
