<?php
/**
 * The template part for displaying the dark CTA section on the front page (static)
 *
 * @package vega
 */
?>
<?php 
global $vega_wp_curr_bg, $vega_wp_prev_bg; 

$vega_wp_frontpage_cta_dark2 = vega_wp_get_option('vega_wp_frontpage_cta_dark2'); 

if($vega_wp_frontpage_cta_dark2 == 'Y') { 
$vega_wp_curr_bg = 'bg-primary'; $vega_wp_prev_bg = $vega_wp_curr_bg;
$cta_page = get_post(vega_wp_get_option('vega_wp_frontpage_cta_dark2_content')); 
$vega_wp_frontpage_cta_dark2_content = $cta_page->post_content;

$vega_wp_frontpage_cta_dark2_parallax = vega_wp_get_option('vega_wp_frontpage_cta_dark2_parallax'); 
$vega_wp_frontpage_cta_dark2_bg_image = vega_wp_get_option('vega_wp_frontpage_cta_dark2_bg_image'); 

$vega_wp_frontpage_cta_dark2_section_id = vega_wp_get_option('vega_wp_frontpage_cta_dark2_section_id'); 

$class = ''; $style = ''; $parallax_str = '';
if($vega_wp_frontpage_cta_dark2_bg_image == '') $class = esc_attr($vega_wp_curr_bg);
else if($vega_wp_frontpage_cta_dark2_parallax != 'Y' && $vega_wp_frontpage_cta_dark2_bg_image != '') $style = 'style="background-image:url(' . esc_url($vega_wp_frontpage_cta_dark2_bg_image) . '); -webkit-background-size:cover; -moz-background-size:cover; -o-background-size:cover; background-size:cover; background-repeat:no-repeat; z-index:0; background-position: center center;"';
else if($vega_wp_frontpage_cta_dark2_parallax == 'Y' && $vega_wp_frontpage_cta_dark2_bg_image != '') { $class = 'parallax-bg'; $parallax_str = 'data-parallax="scroll" data-image-src="' . esc_url($vega_wp_frontpage_cta_dark2_bg_image) . '"'; }
?>
<!-- ========== Call to Action ========== -->
<div class="shadow"></div>
<div class="section frontpage-cta <?php echo $class ?>" <?php echo $parallax_str; ?> id="<?php echo esc_attr($vega_wp_frontpage_cta_dark2_section_id); ?>" <?php echo $style ?>>
    <div class="container wow zoomIn">
        <div class="description"><?php echo do_shortcode($vega_wp_frontpage_cta_dark2_content); ?></div>
    </div>
</div>
<!-- ========== /Call to Action ========== -->
<?php } ?>
