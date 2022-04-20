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
    'site_url' => get_site_url(),
    'user_logged_id' => get_current_user_id(),
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
      "size" => '12',
      "sides" => 2,
      "speed" => "33 1/3",
      "jacket_type" => "Standard Jacket",
      "inner_sleeve" => "White Paper",
      "insert" => "No",
      "packaging" => "None",
      "download_cards" => "None",
      "marketing_stickers" => "None",
      "tests" => "Yes",
      "labels" => "Yes",
      "center_hole" => "Big",
    ],
    "variant_default_opts" => [
      "number" => 300,
      "style" => "Standard Black",
      "colour" => "Black",
      "weight" => "140g",

      "style2" => "Standard Black",
      "colour2" => "Black",
      "weight2" => "140g",

      "style3" => "Standard Black",
      "colour3" => "Black",
      "weight3" => "140g",
    ],
    "product_pricing_custom_tag_price_rules" => [], 
    "product_pricing_total_price_foreach_variant" => "",
    "product_pricing_custom_tag_price_total_rules" => [],
    "product_pricing_total_price" => "@{TOTAL_ALL_Variants_Price}"];

  $pricingSettings = get_post_meta((int) $id, 'product_pricing_custom_settings', true);
  $pricingSettings = $pricingSettings ? $pricingSettings : $default;

  return empty($name) 
    ? $pricingSettings 
    : (isset($pricingSettings[$name]) ? $pricingSettings[$name] : null);
}

/*
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
*/

function clampdown_child_woo_product_pricing_custom_form($product_id = 0) {
  $wpnonce = wp_create_nonce( 'add-request-quote-' . $product_id );
  ?>
  <div 
    id="PRODUCT_PRICING_MODE_APP" 
    data-product-id="<?php echo $product_id ?>" 
    data-wp_nonce="<?php echo $wpnonce ?>" >
    <!-- Content render by React -->
  </div> <!-- #PRODUCT_PRICING_MODE_APP -->
  <?php 
}

add_action('clampdown-child/woo/custom-product-single-content', 'clampdown_child_woo_product_pricing_custom_form');

function clamdown_child_woo_product_single_content() {
  if(is_product() == true) {
    global $post;
    $product = wc_get_product($post);
    $enable_pricing_mode = clampdown_child_woo_get_product_pricing_settings($product->get_id(), 'enable_pricing_mode');
    
    if($enable_pricing_mode === 'true' || $enable_pricing_mode === true) {
      /**
       * Hook clampdown-child/woo/custom-product-single-content
       * 
       * @see clampdown_child_woo_product_pricing_custom_form - 20
       */
      do_action('clampdown-child/woo/custom-product-single-content', $product->get_id());
    } else {
      load_template(CLAMPDOWN_DIR . '/templates/woo/product-single-content.php', false);
    }
  }
}

{
  /**
   * ywraq custom hook
   * 
   */

  function clampdown_child_woo_add_pricing_data_to_raq_item($raq, $product_raq) {
    if(isset($product_raq['pricing_data']) && isset($product_raq['pricing_total'])) {
      $raq['pricing_data'] = $product_raq['pricing_data'];
      $raq['pricing_total'] = $product_raq['pricing_total'];
    }
    return $raq; 
  }

  add_filter('ywraq_add_item', 'clampdown_child_woo_add_pricing_data_to_raq_item', 20, 2); 

  function clampdown_child_woo_render_request_quote_pricing_data_item($raq, $show_more = true) {
    if(!isset($raq['pricing_data']) && !isset($raq['pricing_total'])) return;

    set_query_var('pricing_data', $raq['pricing_data']);
    set_query_var('pricing_total_price', $raq['pricing_total']);
    set_query_var('show_more', $show_more);

    load_template(CLAMPDOWN_DIR . '/templates/woo/request-quote-pricing-data.php', false);
  }

  add_action('clampdown_child/request_quote/custom_name_item_after', 'clampdown_child_woo_render_request_quote_pricing_data_item', 20);

  function clampdown_child_woo_render_raq_variants_by_sides($variants = [], $sides = 0) {
    if(count($variants) == 0) return;
    // var_dump($variants);
    foreach($variants as $index => $item) {
      echo '<ul class="variant-item">';
      ?>
      <li class="product-pricing-data-list__item"><strong>#<?php echo $index + 1; ?></strong></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Number:', 'clampdown-child') ?></span> <?php echo $item['number'] ?></li>
      <li class="product-pricing-data-list__item __divider"><hr /></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $item['style'] ?></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Colour:', 'clampdown-child') ?></span> <?php echo $item['colour'] ?></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $item['weight'] ?></li>
      <?php
      if(in_array($sides, [4, 6, '4', '6'])) {
      ?>
      <li class="product-pricing-data-list__item __divider"><hr /></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $item['style2'] ?></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Colour:', 'clampdown-child') ?></span> <?php echo $item['colour2'] ?></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $item['weight2'] ?></li>
      <?php
      }

      if(in_array($sides, [6, '6'])) {
      ?>
      <li class="product-pricing-data-list__item __divider"><hr /></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $item['style3'] ?></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Colour:', 'clampdown-child') ?></span> <?php echo $item['colour3'] ?></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $item['weight3'] ?></li>
      <?php
      }
      echo '</ul>';
    }
  }

  function clampdown_child_woo_add_custom_meta_pricing_after_created_order($order_id, $post_data, $raq) {
    if(isset($raq['raq_content']) && count($raq['raq_content']) > 0) {
      $raq_content = $raq['raq_content'];
      $pricing_products = [];

      foreach($raq_content as $key => $item) {
        if(isset($item['pricing_total']) && isset($item['pricing_data'])) {
          $item['__key'] = $key;
          array_push($pricing_products, $item);
        }
      }

      /**
       * Has pricing product
       */
      if(count($pricing_products) > 0)
        update_post_meta($order_id, '_pricing_order_data', $pricing_products);
    }

    return $order_id;
  }
  
  add_action('ywraq_after_create_order', 'clampdown_child_woo_add_custom_meta_pricing_after_created_order', 20, 3);

  function clampdown_child_woo_find_pricing_item($pid, $pricing_order_data) {
    $found_key = array_search($pid, array_column($pricing_order_data, 'product_id'));
    return isset($pricing_order_data[$found_key]) ? $pricing_order_data[$found_key] : false;
  }

  function clampdown_child_woo_pricing_data_after_order_itemmeta($item_id, $item, $product) {
    $product_id = $product->get_id();
    $order_id = get_the_ID();
    if(!$order_id) return;

    $pricing_order_data = get_post_meta($order_id, '_pricing_order_data', true);
    if(empty($pricing_order_data) || count($pricing_order_data) == 0) return; 
    
    $pricing_data = clampdown_child_woo_find_pricing_item($product_id, $pricing_order_data);
    if($pricing_data == false) return;

    clampdown_child_woo_render_request_quote_pricing_data_item($pricing_data, $show_more = false);
  }

  add_action('woocommerce_after_order_itemmeta', 'clampdown_child_woo_pricing_data_after_order_itemmeta', 20, 3);

  /**
   * Override price subtotal product pricing order
   * 
   */
  function clampdown_child_woo_custom_raq_cart_to_order_args($args, $cart_item_key, $values, $new_cart) {
    // wp_send_json([$args, $cart_item_key, $values, $new_cart]);
    /**
     * Checl pricing product data
     * 
     */
    if(isset($values['pricing_total'])) {
      $pricing_total = $values['pricing_total'];
      $qty = (int) $values['quantity'];
      $args['totals']['subtotal'] = floatval($pricing_total);
      $args['totals']['total'] = number_format(floatval($pricing_total) * $qty, 2);
    }
    
    return $args;
  }

  add_filter('ywraq_cart_to_order_args', 'clampdown_child_woo_custom_raq_cart_to_order_args', 20, 4);

  function clampdown_child_woo_more_info_product_pricing_order_item($item_id, $item, $order) {
    $order_id = $order->get_id();
    $pricing_order_data = get_post_meta($order_id, '_pricing_order_data', true);
    $product_id = $item['product_id'];
    if(empty($pricing_order_data) || count($pricing_order_data) == 0) return; 

    $pricing_data = clampdown_child_woo_find_pricing_item($product_id, $pricing_order_data);
    if($pricing_data == false) return;

    clampdown_child_woo_render_request_quote_pricing_data_item($pricing_data, $show_more = true);
  }

  add_action('woocommerce_order_item_meta_end', 'clampdown_child_woo_more_info_product_pricing_order_item', 20, 3);
}

function clampdown_child_woo_raq_pdf_info_pricing($product_id = 0, $order_id = 0) {
  if($order_id == 0 || $product_id == 0) return;

  $pricing_order_data = get_post_meta($order_id, '_pricing_order_data', true);
  if(empty($pricing_order_data) || count($pricing_order_data) == 0) return; 
  
  $pricing_data = clampdown_child_woo_find_pricing_item($product_id, $pricing_order_data);
  if($pricing_data == false) return;

  set_query_var('pricing_data', $pricing_data['pricing_data']);
  load_template(CLAMPDOWN_DIR . '/templates/order-pdf-path/info-pricing.php', false);
}

add_action('request_quote_pdf_after_tr_item', 'clampdown_child_woo_raq_pdf_info_pricing', 20, 2);

function clampdown_child_woo_raq_pdf_footer($order_id) {
  ?>
  <div class="raq-pdf-tc">
    <h4><?php _e('Terms & Conditions') ?></h4>
    <p>- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum porta eros eu imperdiet.</p>
    <p>- Pellentesque lobortis sagittis velit, non finibus dolor congue a.</p>
    <p>- Donec interdum posuere auctor. </p>
  </div>
  <div class="raq-pdf-footer">
    <div class="f-logo">
      <img src="<?php echo CLAMPDOWN_DIR . '/images/footer-logo.png'; ?>" width="100px" />
    </div>
    <div class="f-text">
      Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...
    </div>
  </div>
  <?php 
}

add_action('yith_ywraq_quote_template_footer', 'clampdown_child_woo_raq_pdf_footer', 20);