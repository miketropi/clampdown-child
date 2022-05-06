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

add_action('init', function() {
  remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
});

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
      "colour_1_2" => "Cherry",
      "weight" => "140g",
      "splater" => "no",

      "style2" => "Standard Black",
      "colour2" => "Black",
      "colour_2_2" => "Cherry",
      "weight2" => "140g",
      "splater2" => "no",

      "style3" => "Standard Black",
      "colour3" => "Black",
      "colour_3_2" => "Cherry",
      "weight3" => "140g",
      "splater3" => "no",
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
      <li class="product-pricing-data-list__item __divider"><b>A/B</b> <hr /></li>
      <?php clampdown_child_woo_render_sub_variants($item['style'], [
        'colour' => $item['colour'],
        'colour2' => $item['colour_1_2'],
        'weight' => $item['weight'],
        'useSplatter' => $item['splatter'],
        'splatterImage' => $item['splatter_image'],
      ]); ?>
      <?php
      if(in_array($sides, [4, 6, '4', '6'])) {
      ?>
      <li class="product-pricing-data-list__item __divider"><b>C/D</b> <hr /></li>
      <?php clampdown_child_woo_render_sub_variants($item['style2'], [
        'colour' => $item['colour2'],
        'colour2' => $item['colour_2_2'],
        'weight' => $item['weight2'],
        'useSplatter' => $item['splatter2'],
        'splatterImage' => $item['splatter_image2'],
      ]); ?>
      <?php
      }

      if(in_array($sides, [6, '6'])) {
      ?>
      <li class="product-pricing-data-list__item __divider"><b>E/F</b> <hr /></li>
      <?php clampdown_child_woo_render_sub_variants($item['style3'], [
        'colour' => $item['colour3'],
        'colour2' => $item['colour_3_2'],
        'weight' => $item['weight3'],
        'useSplatter' => $item['splatter3'],
        'splatterImage' => $item['splatter_image3'],
      ]); ?>
      <?php
      }
      echo '</ul>';
    }
  }

  /**
   * @param String $style
   * @param Array $args
   *  colour, colour2, weight, useSplatter, splatterImage
   */
  function clampdown_child_woo_render_sub_variants($style, $args = []) {
    $useSplatter = $args['useSplatter'];
    switch($style) {
      case 'Standard Black': 
        ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $style ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $args['weight'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter:', 'clampdown-child') ?></span> <?php echo $useSplatter ?></li>
        <?php if($useSplatter == 'yes') { ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter Colour:', 'clampdown-child') ?></span> <?php echo $args['splatterImage'] ?></li>
        <?php } ?>
        <?php
        break;

      case 'Colour': 
        ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $style ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Colour:', 'clampdown-child') ?></span> <?php echo $args['colour'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $args['weight'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter:', 'clampdown-child') ?></span> <?php echo $useSplatter ?></li>
        <?php if($useSplatter == 'yes') { ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter Colour:', 'clampdown-child') ?></span> <?php echo $args['splatterImage'] ?></li>
        <?php } ?>
        <?php
        break;

      case 'Split': 
      case 'Smash': 
      case 'Clash': 
      case 'Color In Color':
        ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $style ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Colour:', 'clampdown-child') ?></span> <?php echo $args['colour'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Colour 2:', 'clampdown-child') ?></span> <?php echo $args['colour2'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $args['weight'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter:', 'clampdown-child') ?></span> <?php echo $useSplatter ?></li>
        <?php if($useSplatter == 'yes') { ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter Colour:', 'clampdown-child') ?></span> <?php echo $args['splatterImage'] ?></li>
        <?php } ?>
        <?php
        break; 

      defaut: 
        ?>
        <li class="product-pricing-data-list__item"><span><?php _e('#Undefined', 'clampdown-child') ?></span> #Undefined</li>
        <?php
        break;
    }
  }

  function clampdown_child_woo_render_sub_variants_pdf($style, $args = []) {
    $useSplatter = $args['useSplatter'];
    switch($style) {
      case 'Standard Black': 
        ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Style:', 'clampdown-child') ?> <?php echo $style; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Weight:', 'clampdown-child') ?> <?php echo $args['weight']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter:', 'clampdown-child') ?> <?php echo $useSplatter; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php if($useSplatter == 'yes') { ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter Colour:', 'clampdown-child') ?> <?php echo $args['splatterImage']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <?php
        break;

      case 'Colour': 
        ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Style:', 'clampdown-child') ?> <?php echo $style; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Colour:', 'clampdown-child') ?> <?php echo $args['colour']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Weight:', 'clampdown-child') ?> <?php echo $args['weight']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter:', 'clampdown-child') ?> <?php echo $useSplatter; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php if($useSplatter == 'yes') { ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter Colour:', 'clampdown-child') ?> <?php echo $args['splatterImage']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <?php
        break;

      case 'Split': 
      case 'Smash': 
      case 'Clash': 
      case 'Color In Color':
        ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Style:', 'clampdown-child') ?> <?php echo $style; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Colour:', 'clampdown-child') ?> <?php echo $args['colour']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Colour 2:', 'clampdown-child') ?> <?php echo $args['colour2']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Weight:', 'clampdown-child') ?> <?php echo $args['weight']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter:', 'clampdown-child') ?> <?php echo $useSplatter; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php if($useSplatter == 'yes') { ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter Colour:', 'clampdown-child') ?> <?php echo $args['splatterImage']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <?php
        break; 

      defaut: 
        ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('#Undefined:', 'clampdown-child') ?> #Undefined</td>
          <td></td><td></td><td></td>
        </tr>
        <?php
        break;
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
    <h4><?php _e('Terms & Conditions', 'clampdown-child') ?></h4>
    <p><?php _e('- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum porta eros eu imperdiet.', 'clampdown-child'); ?></p>
    <p><?php _e('- Pellentesque lobortis sagittis velit, non finibus dolor congue a.', 'clampdown-child') ?></p>
    <p><?php _e('- Donec interdum posuere auctor.', 'clampdown-child') ?></p>
  </div>
  <div class="raq-pdf-footer">
    <div class="f-logo">
      <img src="<?php echo CLAMPDOWN_DIR . '/images/footer-logo.png'; ?>" width="100px" />
    </div>
    <div class="f-text">
      <?php _e('Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', 'clampdown-child') ?> 
    </div>
  </div>
  <?php 
}

add_action('yith_ywraq_quote_template_footer', 'clampdown_child_woo_raq_pdf_footer', 20);

function clmapdown_child_woo_register_variant_record_images_settings() {
  add_submenu_page(
    'woocommerce', 
    __('Record Images 💿', 'clampdown-child'),
    __('Record Images 💿', 'clampdown-child'),
    'manage_options',
    'record-images-settings',
    'clampdown_child_woo_variant_record_images_settings_callback');
} 

add_action('admin_menu', 'clmapdown_child_woo_register_variant_record_images_settings', 99);

function clampdown_child_woo_variant_record_images_settings_callback() {
  ?>
  <div id="VARIANT_RECORD_IMAGES_SETTINGS">
    <!-- React render -->
  </div> <!-- #VARIANT_RECORD_IMAGES_SETTINGS -->
  <?php
}