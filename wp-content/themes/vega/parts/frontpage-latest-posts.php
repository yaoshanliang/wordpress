<?php
/**
 * The template part for displaying the recent posts on the front page (static)
 *
 * @package vega
 */
?>
<?php 
global $vega_wp_curr_bg, $vega_wp_prev_bg;

$vega_wp_frontpage_latest_posts = vega_wp_get_option('vega_wp_frontpage_latest_posts');

if($vega_wp_frontpage_latest_posts == 'Y') { 
if($vega_wp_prev_bg == 'bg-white') $vega_wp_curr_bg = 'bg-grey-light-2'; else $vega_wp_curr_bg = 'bg-white';  
$vega_wp_prev_bg = $vega_wp_curr_bg;

$vega_wp_frontpage_latest_posts_n = vega_wp_get_option('vega_wp_frontpage_latest_posts_n'); 
$vega_wp_frontpage_latest_posts_heading = vega_wp_get_option('vega_wp_frontpage_latest_posts_heading'); 
$vega_wp_frontpage_latest_posts_section_id = vega_wp_get_option('vega_wp_frontpage_latest_posts_section_id'); 
?>
<!-- ========== Latest Posts ========== -->
<div class="section frontpage-recent-posts <?php echo esc_attr($vega_wp_curr_bg) ?>" id="<?php echo esc_attr($vega_wp_frontpage_latest_posts_section_id) ?>">
    <div class="container">
    
        <?php if($vega_wp_frontpage_latest_posts_heading != '') { ?>
        <h2 class="block-title wow bounceIn"><?php echo esc_html($vega_wp_frontpage_latest_posts_heading) ?></h2>
        <?php } ?>
    
        <div class="row">
            <?php 
            global $post;
            $args = array( 'numberposts' => $vega_wp_frontpage_latest_posts_n );
            $recent_posts = get_posts( $args ); 
            foreach( $recent_posts as $post ){
            setup_postdata( $post ); 
            ?>
            <?php 
            if($vega_wp_frontpage_latest_posts_n == 1)   $class = "col-md-12";
            if($vega_wp_frontpage_latest_posts_n == 2)   $class = "col-md-6 col-sm-6";
            if($vega_wp_frontpage_latest_posts_n == 3)   $class = "col-md-4 col-sm-4";
            ?>
            <div class="<?php echo $class ?> wow zoomIn">
                <?php get_template_part('parts/content','recent'); ?>
            </div>
            <?php } ?>
            <?php wp_reset_postdata();?>
        </div>
        
    </div>
</div>
<!-- ========== /Latest Posts ========== --> 
<?php } ?>