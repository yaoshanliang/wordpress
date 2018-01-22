<?php
/**
 * The template part for displaying the featured image as the top banner
 *
 * @package vega
 */
?>
<?php 
$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'banner-featured-image' );
if($src) { $url = $src[0]; ?>
<!-- ========== Banner - Featured Image ========== -->
<div class="jumbotron image-banner banner-featured-image" style="background:url('<?php echo esc_url($url) ?>') no-repeat 0 0 #ffffff;background-size:cover;background-position:center center">
    <div class="container">
        <h1 class="block-title wow zoomIn" ><?php echo esc_html(vega_wp_title()); ?><h1>
    </div>
</div>
<!-- ========== /Banner - Featured Image ========== -->
<?php } else { get_template_part('parts/banner','none'); } ?>