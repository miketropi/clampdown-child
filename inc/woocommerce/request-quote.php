<?php
/**
 * Request Quote 
 * 
 */

{
  /**
   * Register request quote admin menu page 
   * 
   */
  function clmapdown_child_woo_add_request_quote_admin_menu_page() {
    add_menu_page(
      __('Request Quote', 'clampdown-child'),
      __('Request Quote', 'clampdown-child'),
      'manage_options',
      'woo-request-quote',
      'clampdown_child_woo_request_quote_menu_page_callback',
      'dashicons-text-page',
      56
    );
  }
  
  add_action('admin_menu', 'clmapdown_child_woo_add_request_quote_admin_menu_page');
  
  function clampdown_child_woo_request_quote_menu_page_callback() {
    ob_start();
    ?>
    in develop...
    <?php 
    echo ob_get_clean();
  }
}

function clampdown_child_woo_request_quote_acf_op_init() {
  if( !function_exists('acf_add_options_sub_page') ) return;

  $child = acf_add_options_sub_page([
    'page_title' => __('Request Quote Settings', 'clampdown-child'),
    'menu_title' => __('Settings', 'clampdown-child'),
    'parent_slug' => 'woo-request-quote',
    'menu_slug' => 'request-quote-options'
  ]);
}

add_action('acf/init', 'clampdown_child_woo_request_quote_acf_op_init');