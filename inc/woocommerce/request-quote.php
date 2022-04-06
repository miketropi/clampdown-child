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
