<?php
/**
 * Woo Ajax handle  
 */

function clampdown_child_woo_ajax_get_product_pricing_settings() {
  $productID = $_POST['data']['product'];
  $data = clampdown_child_woo_get_product_pricing_settings($productID);
  wp_send_json([
    'successful' => true, 
    'settings' => $data,
  ]); return;
}

add_action('wp_ajax_clampdown_child_woo_ajax_get_product_pricing_settings', 'clampdown_child_woo_ajax_get_product_pricing_settings');
add_action('wp_ajax_nopriv_clampdown_child_woo_ajax_get_product_pricing_settings', 'clampdown_child_woo_ajax_get_product_pricing_settings');

function clampdown_child_woo_ajax_save_product_pricing_settings() {
  // productID, data
  $data = $_POST['data'];
  $productID = $data['productID'];
  $settings = $data['settings'];

  $result = update_post_meta((int) $productID, 'product_pricing_custom_settings', $settings);
  wp_send_json([
    'successful' => $result,
  ]);
}

add_action('wp_ajax_clampdown_child_woo_ajax_save_product_pricing_settings', 'clampdown_child_woo_ajax_save_product_pricing_settings');
add_action('wp_ajax_nopriv_clampdown_child_woo_ajax_save_product_pricing_settings', 'clampdown_child_woo_ajax_save_product_pricing_settings');