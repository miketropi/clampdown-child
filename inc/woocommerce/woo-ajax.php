<?php
/**
 * Woo Ajax handle  
 */

function clampdown_child_woo_ajax_get_product_pricing_settings() {
  [$product] = $_POST; 

  wp_send_json([
    'enable_pricing_mode' => false,
  ]);
}

add_action('wp_ajax_clampdown_child_woo_ajax_get_product_pricing_settings', 'clampdown_child_woo_ajax_get_product_pricing_settings');
add_action('wp_ajax_nopriv_clampdown_child_woo_ajax_get_product_pricing_settings', 'clampdown_child_woo_ajax_get_product_pricing_settings');