<?php

$cminds_plugin_config = array(
	'plugin-is-pro'				 => TRUE,
	'plugin-is-addon'			 => TRUE,
	'plugin-version'			 => '1.1.4',
	'plugin-abbrev'				 => 'cmpdc',
	'plugin-short-slug'			 => 'product-community',
	'plugin-parent-short-slug'	 => 'product-directory',
	'plugin-settings-url'		 => admin_url('edit.php?post_type=cm-product&page=cm-product-directory-settings#tab-comunity'),
	'plugin-file'				 => CMPDC_PLUGIN_FILE,
	'plugin-dir-path'			 => plugin_dir_path( CMPDC_PLUGIN_FILE ),
	'plugin-dir-url'			 => plugin_dir_url( CMPDC_PLUGIN_FILE ),
	'plugin-basename'			 => plugin_basename( CMPDC_PLUGIN_FILE ),
	'plugin-icon'				 => '',
	'plugin-name'				 => CMPDC_NAME,
	'plugin-license-name'		 => CMPDC_NAME,
	'plugin-slug'				 => '',
	'plugin-menu-item'			 => 'edit.php?post_type=cm-product',
	'plugin-textdomain'			 => CMPDC_SLUG_NAME,
	'plugin-userguide-key'		 => '709-cm-product-community-cmpdc',
	'plugin-store-url'			 => 'https://www.cminds.com/store/cm-product-directory-community-addon-for-wordpress/',
	'plugin-review-url'			 => 'https://wordpress.org/support/view/plugin-reviews/cm-product-directory',
	'plugin-changelog-url'		 => CMPDC_RELEASE_NOTES,
	'plugin-licensing-aliases'	 => array( 'CM Product Directory Community Items' ),
);
