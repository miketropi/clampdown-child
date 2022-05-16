<?php
/**
 * Static 
 * 
 */

function clampdown_enqueue_scripts() {
  /**
   * Fonts
   */
  wp_enqueue_style('clampdown-childtheme-fonts-proxima', CLAMPDOWN_URI . '/font/proxima/stylesheet.css');
  wp_enqueue_style('clampdown-childtheme-fonts-avenir', CLAMPDOWN_URI . '/font/avenir/stylesheet.css');

  /**
   * CSS & JS
   */
  wp_enqueue_style('clampdown-childtheme-style', CLAMPDOWN_URI . '/dist/frontend.clampdown.bundle.css', false, CLAMPDOWN_VER);
  wp_enqueue_script('clampdown-childtheme-script', CLAMPDOWN_URI . '/dist/frontend.clampdown.bundle.js', ['jquery'], CLAMPDOWN_VER, true); 

  wp_localize_script('clampdown-childtheme-script', 'CLAMPDOWN_PHP_DATA', [
    'ajaxurl' => admin_url('admin-ajax.php'),
    'lang' => [],
  ]);
}

add_action('wp_enqueue_scripts', 'clampdown_enqueue_scripts', 40);

function clampdown_css_variables_register() {
  ob_start();
  ?>
  :root {
    --responsive--aligndefault-width: min(calc(100vw - 32px), 980px);
    --responsive--alignwide-width: min(calc(100vw - 32px), 1240px);

    --theme-heading-font: 'Proxima Nova Rg';
    --theme-body-font: 'Avenir LT Std';
    --theme-text-size: 17px;
    --theme-heading-color: #414141;
    --theme-body-color: #414141;
    --theme-accents-color: #B5208B;
  }
  <?php 
  $css = ob_get_clean();
  wp_add_inline_style('clampdown-childtheme-style', $css);
}

add_action('wp_enqueue_scripts', 'clampdown_css_variables_register', 42);