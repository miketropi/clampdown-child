<?php
/**
 * Options 
 */

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page([
    'page_title' 	=> __('Clampdown Settings', 'clampdown-child'),
		'menu_title'	=> __('Clampdown Settings', 'clampdown-child'),
		'menu_slug' 	=> 'clampdown-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
    'icon_url' => 'dashicons-admin-settings',
  ]);

  acf_add_options_sub_page([
    'page_title' 	=> 'Custom My Account',
		'menu_title'	=> 'Custom My Account',
		'parent_slug'	=> 'clampdown-settings',
  ]);
}