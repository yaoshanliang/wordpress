<?php
/**
 * The Header for the theme.
 *
 * Displays all of the <head> section and logo and navigation
 *
 * @package vega
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    
    <!-- ========== Navbar ========== -->
    <div class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            
            <!-- Logo -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></button>
                <?php get_template_part('parts/header', 'logo'); ?>
            </div>
            <!-- /Logo -->
            
            <?php if ( has_nav_menu( 'header' ) ) :  ?>
            <!-- Navigation -->
            <?php wp_nav_menu( array(
                    'theme_location'    => 'header',
                    'depth'             => 3,
                    'container'         => 'div',
                    'container_class'   => 'navbar-collapse collapse',
                    'menu_class'        => 'nav navbar-nav navbar-right menu-header',
                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                    'walker'            => new wp_bootstrap_navwalker()
                    )
                );
            ?>
            <!-- /Navigation -->
            <?php else: ?>
            
            <?php 
            /* $vega_wp_enable_demo = vega_wp_get_option('vega_wp_enable_demo');
            if($vega_wp_enable_demo == 'Y')  */
            vega_wp_example_nav_header(); 
            ?>
            
            <?php endif; ?>
            
            
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- ========== /Navbar ========== --> 
