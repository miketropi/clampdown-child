<?php 
/**
 * Upload / Submit files.
 */

?>

<h2 class="my-account-page-title"><?php _e('Upload / Submit Files', 'clampdown-child') ?></h2>

<?php
clampdown_child_message_tag(
  __('ℹ️ How to prepare audio files before uploading:', 'clampdown-child'),
  wpautop(__('Send us two .wav files, one for each side. That way, you’re in control of the amount of space between songs.', 'clampdown-child')),
);
?>

<div class="upload-submit-form-container">
  <div class="wp-form-here">
    <?php echo do_shortcode('[wpforms id="'. get_field('upload_submit_files_wp_form', 'option') .'"]') ?>
  </div>
  <div class="description-text">
    <div class="sticky-inner">
      <h4><?php _e('How to prepare my art files before uploading:', 'clampdown-child') ?></h4>
      <ol>
        <li>Use the templates you can find on our <a href="/templates/" target="_blank">templates page</a></li>
        <li>Don't leave fonts embedded.</li>
        <li>If you're using photoshop, rasterize your text layers.</li>
        <li>If you're using Illustrator, outline your text.</li> 
        <li>Put your art on a different layer than the template.</li>
        <li>Don't resize the template, you want it to be a minimum of 300dpi.</li>
        <li>Save your art files in CMYK mode, not RGB.</li>
        <li>Remember to put your band name, album title, and matrix number on the spine.</li>
      </ol>
    </div>
  </div>
</div>


