<?php
/**
 * The template part for displaying an open content section for the frontpage (static)
 *
 * @package vega
 */
?>
<?php 
global $vega_wp_curr_bg, $vega_wp_prev_bg; 

$vega_wp_frontpage_open1 = vega_wp_get_option('vega_wp_frontpage_open1'); 

if($vega_wp_frontpage_open1 == 'Y') { 
if($vega_wp_prev_bg == 'bg-white') $vega_wp_curr_bg = 'bg-grey-light-2'; else $vega_wp_curr_bg = 'bg-white';  
$vega_wp_prev_bg = $vega_wp_curr_bg;

$vega_wp_frontpage_open1_heading = vega_wp_get_option('vega_wp_frontpage_open1_heading'); 

$open_content_page = get_post(vega_wp_get_option('vega_wp_frontpage_open1_content')); 
$vega_wp_frontpage_open1_content = $open_content_page->post_content;

$vega_wp_frontpage_open1_section_id = vega_wp_get_option('vega_wp_frontpage_open1_section_id'); 
?>
<!-- ========== Featured Section ========== -->
<div class="section frontpage-open1 <?php echo esc_attr($vega_wp_curr_bg) ?>" id="<?php echo esc_attr($vega_wp_frontpage_open1_section_id) ?>">
    <div class="container">
        <h2 class="block-title wow zoomIn"><?php echo esc_html($vega_wp_frontpage_open1_heading) ?></h2>
        <div class="wow fadeIn"><?php echo do_shortcode($vega_wp_frontpage_open1_content); ?></div>
    </div>
</div>
<!-- ========== /Featured Section ========== -->
<?php } ?>
