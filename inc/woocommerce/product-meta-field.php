<?php
/**
 * Producr register custom meta fields
 * 
 */

/**
 * Register meta box
 */
function clampdown_child_product_custom_meta() {
  add_meta_box(
    'clampdown_product_custom_meta_fields',
    __('Pricing Settings', 'clampdown-child'),
    'clampdown_child_product_custom_meta_callback',
    'product'
  );
}

add_action('add_meta_boxes', 'clampdown_child_product_custom_meta');

/**
 * Product meta box callback template 
 */
function clampdown_child_product_custom_meta_callback($product) {
  $productID = $product->ID;
  if(!$productID) return; 

  ob_start();
  ?>
  <div id="CLAMPDOWN_PRODUCT_PRICING_SETTINGS_APP" data-product="<?php echo $productID; ?>">
    <!-- React rendering -->
  </div> <!-- #CLAMPDOWN_PRODUCT_PRICING_SETTINGS_APP -->
  <?php 
  echo ob_get_clean();
}