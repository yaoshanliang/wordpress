<?php
/**
 * The template part for displaying the Custom Header as the top banner
 *
 * @package vega
 */
?>
<?php $custom_header = get_header_image();  ?>
<!-- ========== Banner - Custom Header ========== -->
<div class="jumbotron image-banner banner-custom-header" style="background:url('<?php echo esc_url($custom_header); ?>') no-repeat 0 0 #ffffff;background-size:cover;background-position:center center">
    <div class="container">
        <h1 class="block-title wow zoomIn"><?php echo esc_html(vega_wp_title()); ?></h1>
    </div>
</div>
<!-- ========== /Banner - Custom Header ========== -->