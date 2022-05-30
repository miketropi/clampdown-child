<?php 

function clampdown_load_header() {
  load_template(CLAMPDOWN_DIR . '/templates/header-default.php', false);
}

/**
 * @param String $name
 * 
 * @return Html SVG
 */
function clampdown_svg($name) {
  $icons = require(__DIR__ . '/svg.php'); 
  return (isset($icons[$name])) ? $icons[$name] : '';
}