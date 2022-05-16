<?php 
/**
 * Template tags
 */

function clampdown_child_message_tag($title = '', $content = '', $type = 'info') {
  ?>
  <div class="cc-message-tag cc-message-tag__<?php echo $type; ?>">
    <?php if(!empty($title)) { ?>  
    <h4 class="cc-message-tag__title"><?php echo $title; ?></h4>
    <?php } ?>
    <div class="cc-message-tag__content">
      <?php echo $content; ?>
    </div>
  </div>
  <?php
}