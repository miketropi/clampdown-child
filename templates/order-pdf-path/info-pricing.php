<?php
/**
 * Info pricing 
 */

extract($pricing_data);
?>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Size: ') ?> <?php echo stripcslashes($size); ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Sides: ') ?> <?php echo $sides; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Speed: ') ?> <?php echo $speed; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Jacket Type: ') ?> <?php echo $jacket_type; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Inner Sleeve: ') ?> <?php echo $inner_sleeve; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Insert: ') ?> <?php echo $insert; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Packaging: ') ?> <?php echo $packaging; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Download Cards: ') ?> <?php echo $download_cards; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Marketing Stickers: ') ?> <?php echo $marketing_stickers; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="text-right">↳</td>
  <td><?php _e('Variants: ') ?></td>
  <td></td><td></td><td></td>
</tr>

<?php foreach ($variables as $index => $item) { ?>
<tr>
  <td></td>
  <td><strong>#<?php echo ($index + 1); ?></strong></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td></td>
  <td>↳ <?php _e('Number:', 'clampdown-child') ?> <?php echo $item['number']; ?></td>
  <td></td><td></td><td></td>
</tr>

<tr>
  <td></td>
  <td><b>A/B</b></td>
  <td></td><td></td><td></td>
</tr>
<?php clampdown_child_woo_render_sub_variants_pdf($item['style'], [
  'colour' => $item['colour'],
  'colour2' => $item['colour_1_2'],
  'weight' => $item['weight'],
  'useSplatter' => $item['splatter'],
  'splatterImage' => $item['splatter_image'],
]); ?>

<!--
<tr>
  <td></td>
  <td>↳ <?php _e('Style:', 'clampdown-child') ?> <?php echo $item['style']; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td></td>
  <td>↳ <?php _e('Colour:', 'clampdown-child') ?> <?php echo $item['colour']; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td></td>
  <td>↳ <?php _e('Weight:', 'clampdown-child') ?> <?php echo $item['weight']; ?></td>
  <td></td><td></td><td></td>
</tr>
-->

<?php if(in_array($sides, [4, 6, '4', '6'])) { ?>
<tr>
  <td></td>
  <td><b>C/D</b></td>
  <td></td><td></td><td></td>
</tr>
<?php clampdown_child_woo_render_sub_variants_pdf($item['style2'], [
  'colour' => $item['colour2'],
  'colour2' => $item['colour_2_2'],
  'weight' => $item['weight2'],
  'useSplatter' => $item['splatter2'],
  'splatterImage' => $item['splatter_image2'],
]); ?>
<!-- 
<tr>
  <td></td>
  <td>↳ <?php _e('Style 2:', 'clampdown-child') ?> <?php echo $item['style2']; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td></td>
  <td>↳ <?php _e('Colour 2:', 'clampdown-child') ?> <?php echo $item['colour2']; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td></td>
  <td>↳ <?php _e('Weight 2:', 'clampdown-child') ?> <?php echo $item['weight2']; ?></td>
  <td></td><td></td><td></td>
</tr>
-->
<?php } ?>

<?php if(in_array($sides, [6, '6'])) { ?>
<tr>
  <td></td>
  <td><b>E/F</b></td>
  <td></td><td></td><td></td>
</tr>
<?php clampdown_child_woo_render_sub_variants_pdf($item['style3'], [
  'colour' => $item['colour3'],
  'colour2' => $item['colour_3_2'],
  'weight' => $item['weight3'],
  'useSplatter' => $item['splatter3'],
  'splatterImage' => $item['splatter_image3'],
]); ?>
<!-- 
<tr>
  <td></td>
  <td>↳ <?php _e('Style 3:', 'clampdown-child') ?> <?php echo $item['style3']; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td></td>
  <td>↳ <?php _e('Colour 3:', 'clampdown-child') ?> <?php echo $item['colour3']; ?></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td></td>
  <td>↳ <?php _e('Weight 3:', 'clampdown-child') ?> <?php echo $item['weight3']; ?></td>
  <td></td><td></td><td></td>
</tr>
-->
<?php } ?>

<?php } ?>