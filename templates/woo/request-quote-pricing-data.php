<?php 
/**
 * Request a quote data user selected 
 */
extract($pricing_data);

$total = $pricing_total_price;
$total_price = wc_price(floatval($total));
?>
<div class="product-pricing-data-list"> 
  <div class="product-pricing-data-list__header">
    <label><?php _e('Price:', 'clampdown-child') ?></label> <?php echo $total_price; ?>
  </div>
  <ul class="product-pricing-data-list__ul <?php echo ($show_more == true) ? '__show-more-style' : '' ?>">
    <li class="product-pricing-data-list__item"><span><?php _e('Size:', 'clampdown-child') ?></span> <?php echo stripcslashes($size); ?></li>
    <li class="product-pricing-data-list__item"><span><?php _e('Sides:', 'clampdown-child') ?></span> <?php echo $sides; ?></li>
    <li class="product-pricing-data-list__item"><span><?php _e('Speed:', 'clampdown-child') ?></span> <?php echo $speed; ?></li>
    <li class="product-pricing-data-list__item"><span><?php _e('Jacket Type:', 'clampdown-child') ?></span> <?php echo $jacket_type; ?></li>
    <li class="product-pricing-data-list__item"><span><?php _e('Inner Sleeve:', 'clampdown-child') ?></span> <?php echo $inner_sleeve; ?></li>
    <li class="product-pricing-data-list__item"><span><?php _e('Insert:', 'clampdown-child') ?></span> <?php echo $insert; ?></li>
    <li class="product-pricing-data-list__item"><span><?php _e('Packaging:', 'clampdown-child') ?></span> <?php echo $packaging; ?></li>
    <li class="product-pricing-data-list__item"><span><?php _e('Download Cards:', 'clampdown-child') ?></span> <?php echo $download_cards; ?></li>
    <li class="product-pricing-data-list__item"><span><?php _e('Marketing Stickers:', 'clampdown-child') ?></span> <?php echo $marketing_stickers; ?></li>
    <li class="product-pricing-data-list__item"><span><?php _e('Variants:', 'clampdown-child') ?></span> <?php clampdown_child_woo_render_raq_variants_by_sides($variables, $sides) ?></li>
  </ul>
  <?php if($show_more == true) { ?>
  <a class="__show-more-data-list"><?php _e('Show more', 'clampdown-child') ?></a>
  <?php } ?>
  <div class="product-pricing-data-list__footer">
    <label><?php _e('Price:', 'clampdown-child') ?></label> <?php echo $total_price; ?>
  </div>
</div> <!-- .product-pricing-data-list -->
