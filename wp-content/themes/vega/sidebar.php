<?php
/**
 * The template for displaying the sidebar
 *
 * @package vega
 */
?>
<?php //$vega_wp_enable_demo = vega_wp_get_option('vega_wp_enable_demo'); ?>

<?php if ( is_active_sidebar( 'sidebar' ) ) { ?>

<div class="sidebar-widgets" >
    <?php dynamic_sidebar( 'sidebar' ); ?>
</div>

<?php } 
//else if($vega_wp_enable_demo == 'Y') { vega_wp_example_sidebar(); } 
else  { vega_wp_example_sidebar(); } 
?> 
