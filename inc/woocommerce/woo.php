<?php
/**
 * Custom Woo
 * 
 */

/**
 * Woo enqueue scripts
 */
function clampdown_child_woo_enqueue_scripts() {
  wp_enqueue_style('clamdown-child-woo-style', CLAMPDOWN_URI . '/dist/woofrontend.clampdown.bundle.css', false, CLAMPDOWN_VER);
  wp_enqueue_script('clamdown-child-woo-script', CLAMPDOWN_URI . '/dist/woofrontend.clampdown.bundle.js', ['jquery'], CLAMPDOWN_VER, true);

  wp_localize_script('clamdown-child-woo-script', 'CLAMPDOWN_PHP_WOO_DATA', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'lang' => []
  ]);
}

add_action('wp_enqueue_scripts', 'clampdown_child_woo_enqueue_scripts', 30);

/**
 * Backend enqueue scripts 
 */
function clampdown_child_woo_admin_enqueue_scripts() {
  wp_enqueue_style('clamdown-child-admin-woo-style', CLAMPDOWN_URI . '/dist/woobackend.clampdown.bundle.css', false, CLAMPDOWN_VER);
  wp_enqueue_script('clamdown-child-admin-woo-script', CLAMPDOWN_URI . '/dist/woobackend.clampdown.bundle.js', ['jquery'], CLAMPDOWN_VER, true);

  wp_localize_script('clamdown-child-admin-woo-script', 'CLAMPDOWN_PHP_WOO_DATA', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'lang' => [],
  ]);
}

add_action('admin_enqueue_scripts', 'clampdown_child_woo_admin_enqueue_scripts', 30);

function clampdown_child_woo_get_product_pricing_settings($id = 0, $name = null) {
  $default = [
    "enable_pricing_mode" => "false", 
    "general_default_opts" => [
      "size" => '12" Pricing',
      "sides" => 2,
      "speed" => "33 1/3",
      "jacket_type" => "Standard Jacket",
      "inner_sleeve" => "White",
      "insert" => "None",
      "packaging" => "Poly Bags",
      "download_cards" => "None",
      "marketing_stickers" => "None",
      "tests" => "Yes",
      "labels" => "Yes"
    ],
    "variant_default_opts" => [
      "number" => 300,
      "style" => "Standard",
      "colour" => "Black",
      "weight" => "140g",
    ],
    "product_pricing_custom_tag_price_rules" => [], 
    "product_pricing_total_price_recipe" => ""];

  $pricingSettings = get_post_meta((int) $id, 'product_pricing_custom_settings', true);
  $pricingSettings = $pricingSettings ? $pricingSettings : $default;

  return empty($name) 
    ? $pricingSettings 
    : (isset($pricingSettings[$name]) ? $pricingSettings[$name] : null);
}

function clamdown_child_woo_is_product_pricing_mode_handle() {
  if(is_product() == true) {
    global $post; 
    $product = wc_get_product($post);
    $enable_pricing_mode = clampdown_child_woo_get_product_pricing_settings($product->get_id(), 'enable_pricing_mode');

    if($enable_pricing_mode == 'true' || $enable_pricing_mode == true) {
      remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
      remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

      add_action('woocommerce_single_product_summary', 'clampdown_child_woo_product_pricing_custom_form', 32);
    }
  }
} 

add_action('wp_head', 'clamdown_child_woo_is_product_pricing_mode_handle');

function clampdown_child_woo_product_pricing_custom_form() {
  global $post; 
  $product = wc_get_product($post);
  ?>
  <div id="PRODUCT_PRICING_MODE_APP" data-product-id="<?php echo $product->get_id() ?>">
    <!-- Content render by React -->
  </div> <!-- #PRODUCT_PRICING_MODE_APP -->
  <?php 
}