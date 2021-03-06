<?php
/**
 * Theme functions 
 * 
 */

{
  /**
   * Define 
   */
  define('CLAMPDOWN_VER', '1.0.0');
  define('CLAMPDOWN_DIR', get_stylesheet_directory());
  define('CLAMPDOWN_URI', get_stylesheet_directory_uri());
}

{
  /**
   * Include
   */
  require(CLAMPDOWN_DIR . '/inc/static.php');
  require(CLAMPDOWN_DIR . '/inc/helpers.php');
  require(CLAMPDOWN_DIR . '/inc/template-tags.php');
  require(CLAMPDOWN_DIR . '/inc/hooks.php');
  require(CLAMPDOWN_DIR . '/inc/ajax.php');
  require(CLAMPDOWN_DIR . '/inc/options.php');

  if(class_exists('WooCommerce')) {
    require(CLAMPDOWN_DIR . '/inc/woocommerce/woo.php');
    require(CLAMPDOWN_DIR . '/inc/woocommerce/woo-ajax.php');
    require(CLAMPDOWN_DIR . '/inc/woocommerce/product-meta-field.php');

    /**
     * Request Quote 
     */
    // require(CLAMPDOWN_DIR . '/inc/woocommerce/request-quote.php');
  }
}


function clampdown_enqueue_styles() {
  $parenthandle = 'twentytwentyone-style';
  $theme = wp_get_theme();
  wp_enqueue_style( 
    $parenthandle, 
    get_template_directory_uri() . '/style.css', 
    [],  
    $theme->parent()->get('Version')
  );
  wp_enqueue_style( 
    'clampdown-style', 
    get_stylesheet_uri(),
    [$parenthandle],
    $theme->get('Version') 
  );
}

add_action('wp_enqueue_scripts', 'clampdown_enqueue_styles');