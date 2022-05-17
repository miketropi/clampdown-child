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
    'extra' => [
      'product_thumbnail_url' => get_the_post_thumbnail_url($productID, 'full'),
    ],
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

function clampdown_child_woo_get_orders_by_user_logged_in() {
  wp_send_json(clampdown_child_woo_render_option_orders_by_user(get_current_user_id()));
}

add_action('wp_ajax_clampdown_child_woo_get_orders_by_user_logged_in', 'clampdown_child_woo_get_orders_by_user_logged_in');
add_action('wp_ajax_nopriv_clampdown_child_woo_get_orders_by_user_logged_in', 'clampdown_child_woo_get_orders_by_user_logged_in');