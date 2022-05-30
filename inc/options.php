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
    'page_title' 	=> 'My Account 🙎‍♂️',
		'menu_title'	=> 'My Account 🙎‍♂️',
		'menu_slug' 	=> 'acf-options-custom-my-account',
		'parent_slug'	=> 'clampdown-settings',
  ]);

	// acf_add_options_sub_page([
  //   'page_title' 	=> 'RaQ Email Template 📧',
	// 	'menu_title'	=> 'RaQ Email 📧',
	// 	'menu_slug' 	=> 'clampdown-settings-raq-email-template',
	// 	'parent_slug'	=> 'clampdown-settings',
  // ]);

	acf_add_options_sub_page([
    'page_title' 	=> 'RaQ PDF 🧾',
		'menu_title'	=> 'RaQ PDF 🧾',
		'menu_slug' 	=> 'clampdown-settings-raq-pdf',
		'parent_slug'	=> 'clampdown-settings',
  ]);
}

if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_62845e3c98868',
		'title' => 'Clampdown Email Template Settings',
		'fields' => array(
			array(
				'key' => 'field_62845ea2a69c0',
				'label' => 'General Settings',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_62845eb8a69c1',
				'label' => 'New user Registration Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6285eade88d64',
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
				'message' => 'Woo mail template setting <a href="/wp-admin/admin.php?page=wc-settings&tab=email&section=wc_email_customer_new_account" target="_blank">here</a>.',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_6285eabe88d63',
				'label' => 'Quote Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_62859d46f5813',
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
				'message' => 'After the user has requested a quote we can use this.
	Woo mail template setting <a href="/wp-admin/admin.php?page=wc-settings&tab=email&section=yith_ywraq_send_email_request_quote_customer" target="_blank">here</a>.',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_62846311da46f',
				'label' => 'Invoice 1 Email Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_62859cc703303',
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
				'message' => 'This one is kind of the same as the Quote saved / Pending payment so maybe the quote is actually the same as an invoice?',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_6284632bda470',
				'label' => 'Invoice 1 Email Template',
				'name' => 'invoice_1_email_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_6284632bda471',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Here\'s your invoice for {#ORDER_ID}. A 50% deposit gets us started',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_6284632bda472',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>Here\'s your invoice!</p>
	
	<p>If you like what you see feel free to get started with us by paying a 50% deposit to get the ball rolling.</p>
	
	<p>You can always log in to <a href="/my-account">your account here ↗</a> to pay for any of your quotes, check the status of any of your orders, upload your art and audio files and to manage your account details. </p>
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
			array(
				'key' => 'field_62846450aeacd',
				'label' => 'Deposit Paid Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_62859e1379a3d',
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
				'message' => 'We use this after they have paid their 50% deposit. This status gets changed automatically in the case of a credit card but manualy in teh case of a bank transfer once payment is received',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_62846463aeace',
				'label' => 'Deposit Paid Mail Template',
				'name' => 'deposit_paid_mail_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_62846463aeacf',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Deposit Received for {#ORDER_ID}',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62846463aead0',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>Your 50% deposits been paid. Thank you! </p>
	
	<p>Your order is now getting slotted into our production schedule and we\'re excuted to get the ball rolling our records! First, we\'ll make your Tests, send them out for your approval and then get your records into production once approved.</p>
	
	<p>Please log in to <a href="/my-account">your account here ↗</a> to upload your art and audio files as a next step. To make sure everything goes smoothly please be sure to follow the instructions on the upload page carefully on how to prepare your art and audio files before submitting them.</p>
	
	<p>If you need any help with that we offer an art and/or audio conversion service as well</p>
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
			array(
				'key' => 'field_628465c007a76',
				'label' => 'Make Tests Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6285a0877facb',
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
				'message' => 'We will change the status manually here once parts have arrived and the status should be reflected on the order details page in MyAcount and the chnage in status should also trigger the email',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_628465cf07a77',
				'label' => 'Make Tests Mail Template',
				'name' => 'make_tests_mail_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_628465cf07a78',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Stampers Finished for {#ORDER_ID}',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_628465cf07a79',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Your Tests are getting ready to be pressed!
	
	We should be ready to ship these out to you for your approval in the next x days.
	
	If you haven\'t already, please make sure we have the right address to ship those out to by logging into <a href="/my-account">your account here ↗</a> and clicking on \'Addresses\' to edit it if neccessary.
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
			array(
				'key' => 'field_628467393e978',
				'label' => 'Ship Tests Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6285a0d77facc',
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
				'message' => 'We will change the status manually here once the test presses have been pressed and are ready for shipment. The status should be reflected on the order details page in My Account and the change in status should also trigger the email. 
	
	Do we need something like this in order for the tracking number to get included in this template?
	
	<a href="https://woocommerce.com/products/shipment-tracking/?utm_source=google&utm_medium=cpc&utm_campaign=marketplace_search_brand_row&utm_content=woocommerce_+shipment.tracking&gclid=Cj0KCQjwspKUBhCvARIsAB2IYutDTINPeHw7MILTuBK0rdVzj-HY0buhC31a8sB8myQf84qexf5J-KkaAmcVEALw_wcB " target="_blank">Shipment Tracking</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_628467483e979',
				'label' => 'Ship Tests Mail Template',
				'name' => 'ship_tests_mail_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_628467483e97a',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Tests Have Been Shipped for {#ORDER_ID}',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_628467483e97b',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>Your Tests have been shipped out to you!</p>
	
	<p>Here is your tracking number so you can follow along: </p>
	
	<b>({#TRACKING_URL})</b>
	
	Once you receive them <b>(what do they do here? Listen to it, check quality and sound? Book a Call with you? How do they tell you they are approved?)</b>
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
			array(
				'key' => 'field_62846a5665029',
				'label' => 'Tests Approval Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6285a1502243c',
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
				'message' => 'We will change the status manually here once the customer sends us an email that the Test presses have been approved. The status chnage should be reflected on the order details page in MyAcount and the chnage in status should also trigger the email',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_62846a646502a',
				'label' => 'Tests Approval Mail Template',
				'name' => 'tests_approval_mail_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_62846a646502b',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Thanks for approving your test presses for {#ORDER_ID}, we\'ll put these into the production schedule now',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62846a646502c',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>Thanks for approving your test presses!</p>
	
	<p>Next, we\'ll email you the Jacket Proofs for your approval and then get everything pressed for you.</p>
	
	<p>Rest assured we won\'t move your order forward until we get your approval so be on the lookout for that email. <b>(It usually takes x amount of time)</b></p>
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
			array(
				'key' => 'field_62846bd1947f7',
				'label' => 'Art Approval Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6285a1672243d',
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
				'message' => 'We will change the status manually here once the Art file for the record jackets is finalized and ready for approval. The status change should be reflected on the order details page in My Account and the change in status should also trigger the email',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_62846be0947f8',
				'label' => 'Art Approval Mail Template',
				'name' => 'art_approval_mail_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_62846be0947f9',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Attn Needed: Jacket Proofs attached for {#ORDER_ID}',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62846be0947fa',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>Your art is ready for approval!</p>
	
	<p>Please review the jackets attached and inserts if you ordered any and let us know if we can move forward.</p>
	
	<p>Rest assured we won\'t move your order forward until we get your approval so please have a look when you get a chance and we will carry on with production</p>
	
	<p><b>(what do they do here? Listen to it, check quality and sound? Book a Call with you? How do they tell you they are approved?)</b></p>
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
			array(
				'key' => 'field_62846eeb9fad5',
				'label' => 'Press Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6285a17a2243e',
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
				'message' => 'We will change the status manually here once the customer emails us back and tells us that Art has been approved. The status change should be reflected on the order details page in My Account and the change in status should also trigger the email',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_62846f849fad6',
				'label' => 'Press Mail Template',
				'name' => 'press_mail_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_62846f849fad7',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Your project is scheduled to be pressed on (give a date) for {#ORDER_ID}',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62846f849fad8',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>Thanks for approving your art!</p>
	
	<p>Your project is now scheduled to be pressed <b>(It usually takes x amount of time)</b>. As soon as this step is fininshed we will send you an email letting you know and then it will be time to assemble them all.</p>
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
			array(
				'key' => 'field_6285a1c0c1404',
				'label' => 'Assemble Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6285a1cdc1405',
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
				'message' => 'We will change the status manually here once the records have been pressed. The status change should be reflected on the order details page in My Account and the change in status should also trigger the email',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_6285a1e3c1406',
				'label' => 'Assemble Mail Template',
				'name' => 'assemble_mail_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_6285a1e3c1407',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Your records have been pressed, and are being assembled for {#ORDER_ID}',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_6285a1e3c1408',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>As the subject says, your records have been pressed, and are currently being assembled. <b>(This usually takes x amount of time)</b></p>
	
	<p>If you want to get a head start on things you can go ahead and make your final payment here so that we can ship out as soon as it\'s done. <b>(Tell them how to complete payment)</b></p>
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
			array(
				'key' => 'field_6285a2805f499',
				'label' => 'Invoice 2 Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6285a28b5f49a',
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
				'message' => 'We will change the status manually here once the records have been assembled and are ready to ship. The status change should be reflected on the order details page in My Account and the change in status should also trigger the email',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_6285a2a15f49b',
				'label' => 'Invoice 2 Mail Template',
				'name' => 'invoice_2_mail_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_6285a2a15f49c',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Here\'s your final invoice for {#ORDER_ID}',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_6285a2a15f49d',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>Please find attached your final invoice for {#ORDER_ID}.</p>
	
	<p>If you haven\'t already, please pay it by doing... <b>(tell them how to pay it)</b></p>
	
	<p>As soon as it\'s paid in full your shipping can be arranged. Please understand that we do not have the space to hold your records for an extended amount of time and so we are looking forward to getting these in your hands ASAP.</p>
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
			array(
				'key' => 'field_6285a333992a4',
				'label' => 'Completed / Shipped Mail Template',
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
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_6285a3b4992a5',
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
				'message' => 'We will change the status manually here once the test presses have been pressed and are ready for shipment. The status should be reflected on the order details page in My Account and the change in status should also trigger the email. 
	
	Do we need something like this in order for the tracking number to get included in this template?
	
	<a href="https://woocommerce.com/products/shipment-tracking/?utm_source=google&utm_medium=cpc&utm_campaign=marketplace_search_brand_row&utm_content=woocommerce_+shipment.tracking&gclid=Cj0KCQjwspKUBhCvARIsAB2IYutDTINPeHw7MILTuBK0rdVzj-HY0buhC31a8sB8myQf84qexf5J-KkaAmcVEALw_wcB " target="_blank">Shipment Tracking</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_6285a40e992a6',
				'label' => 'Completed / Shipped Mail Template',
				'name' => 'completed_shipped_mail_template',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_6285a40e992a7',
						'label' => 'Subject',
						'name' => 'subject',
						'type' => 'text',
						'instructions' => 'Type your subject email',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Your records have shipped for {#ORDER_ID}, thanks pal!',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_6285a40e992a8',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'wysiwyg',
						'instructions' => 'Type your email content.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>Your records have been shipped out to you!</p>
	
	<p>Here is your tracking number so you can follow along: </p>
	
	<b>({#TRACKING_URL})</b>
	
	<p>I know it was a bit of a process to get this all done but overall we are very happy with how they turned out and we hope you are too!</p>
	
	<p><b>Once they receive them (what do they do here? Listen to it, check quality and sound? Book a Call with you to make sure they are satisfied?</b></p>
	
	<p>Sincerely,<br />
	Billy Bones and the Clampdown Team<br />
	PS. See our <a href="/faq/">FAQ\'s here ↗</a></p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'clampdown-settings-raq-email-template',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'field',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));
	
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