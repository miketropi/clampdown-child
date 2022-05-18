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

	acf_add_options_sub_page([
    'page_title' 	=> 'RaQ Email Template 📧',
		'menu_title'	=> 'RaQ Email 📧',
		'menu_slug' 	=> 'clampdown-settings-raq-email-template',
		'parent_slug'	=> 'clampdown-settings',
  ]);
}

if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_6281c6fe8115b',
		'title' => 'Custom My Account Settings',
		'fields' => array(
			array(
				'key' => 'field_6281c71e94982',
				'label' => 'Upload / Submit Files',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6281c7c039043',
				'label' => 'Note',
				'name' => '',
				'type' => 'message',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => 'Custom template in <code>~/themes/clampdown-child/templates/woo/my-account/upload-submit-files.php</code>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_6281c73594983',
				'label' => 'Form',
				'name' => 'upload_submit_files_gform',
				'type' => 'text',
				'instructions' => 'Shortcode form ([gravityform id="1" title="false"])',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_6281c88cd4cb4',
				'label' => 'Make a Secure Payment',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6281c8afd4cb5',
				'label' => 'Note',
				'name' => '',
				'type' => 'message',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => 'Custom template in <code>~/themes/clampdown-child/templates/woo/my-account/make-a-secure-payment.php</code>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_6281c8bbd4cb6',
				'label' => 'Form',
				'name' => 'make_a_secure_payment_gform',
				'type' => 'text',
				'instructions' => 'Shortcode form ([gravityform id="1" title="false"])',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_6281c9e1eb295',
				'label' => 'Submit General Inquiry',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6281c9f2eb296',
				'label' => 'Note',
				'name' => '',
				'type' => 'message',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => 'Custom template in <code>~/themes/clampdown-child/templates/woo/my-account/submit-general-inquiry.php</code>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_6281c9feeb297',
				'label' => 'Form',
				'name' => 'submit_general_inquiry_gform',
				'type' => 'text',
				'instructions' => 'Shortcode form ([gravityform id="1" title="false"])',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-custom-my-account',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'left',
		'instruction_placement' => 'field',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));
	
	acf_add_local_field_group(array(
		'key' => 'group_624e49448630a',
		'title' => 'Request Quote Settings',
		'fields' => array(
			array(
				'key' => 'field_624e497196996',
				'label' => 'General',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_624e49cf96997',
				'label' => 'Login Page',
				'name' => 'login_page',
				'type' => 'page_link',
				'instructions' => 'Request quote requires user logged. Please setup a page for users able to Register/Login.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
					0 => 'page',
				),
				'taxonomy' => '',
				'allow_null' => 0,
				'allow_archives' => 1,
				'multiple' => 0,
			),
			array(
				'key' => 'field_624e4ade03bd5',
				'label' => 'Email',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'request-quote-options',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'left',
		'instruction_placement' => 'field',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));
	
	endif;		