<?php
/**
 * Vega WP functions and definitions
 *
 * @package vega
 */
?>
<?php

### THEME DEFAULTS ###
require get_template_directory() . '/customize/theme-defaults.php';


### SETUP ###

if ( ! function_exists( 'vega_wp_setup' ) ) :
function vega_wp_setup() {

    global $vega_wp_defaults;
    
    #make theme available for translation. Translations can be filed in the /languages/ directory
    load_theme_textdomain( 'vega', get_template_directory() . '/languages' ); 

    #add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    #let WordPress manage the document title
    add_theme_support( 'title-tag' );

    #support for post thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 300, 250, true );
    add_image_size( 'vega-post-thumbnail-recent', 350, 220, true );

    #navigation menus
    register_nav_menus( array(
        'header'    =>  __( 'Header Menu', 'vega' ),
        'footer'    =>  __( 'Footer Menu', 'vega' ),
    ) );
    
    #custom header support
    $args = array(
        'flex-width'    => true,
        'width'         => 1920,
        'flex-height'    => true,
        'height'        => 600,
        'default-image' => $vega_wp_defaults['vega_wp_custom_header'],
    );
    add_theme_support( 'custom-header', $args );
    
    #custom logo support
    add_theme_support( 'custom-logo', array('height' => 45, 'width' => 165,'flex-height' => true,'flex-width'  => true ) );
    
    #page excerpts
    add_post_type_support('page', 'excerpt');
    
}
endif;
add_action( 'after_setup_theme', 'vega_wp_setup' );


### AFTER SETUP ###

function vega_wp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vega_wp_content_width', 1200 );
}
add_action( 'after_setup_theme', 'vega_wp_content_width', 0 );



### FILTERS ###

function vega_wp_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'vega_wp_move_comment_field_to_bottom' );

function vega_wp_excerpt_length( $length ) {
	return 65;
}
add_filter( 'excerpt_length', 'vega_wp_excerpt_length', 999 );


### STYLES AND SCRIPTS ###

function vega_wp_scripts() {
    
    /** CSS **/
    
    #bootstrap, fontawesome, bootstrapsocial
    wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
    wp_register_style('font-awesome', get_template_directory_uri().'/assets/css/font-awesome.min.css' );
    wp_register_style('bootstrap-social', get_template_directory_uri().'/assets/css/bootstrap-social.css' );
    
    #animate.css
    wp_enqueue_style('animate-css', get_template_directory_uri().'/assets/css/animate.css');
    
    #fonts
    wp_enqueue_style('vega-wp-googlefont1',
    '//fonts.googleapis.com/css?family=Raleway:400,700,400italic,700italic,300,300italic,200italic,500,100,100italic,200,500italic,600,600italic,800,800italic,900,900italic');
    wp_enqueue_style('vega-wp-googlefont2', 
    '//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic');

    #default stylesheet
    $deps = array('bootstrap', 'font-awesome', 'bootstrap-social');
    wp_enqueue_style('vega-wp-style', get_stylesheet_uri(), $deps );
        
    #color scheme
    $vega_wp_color_stylesheet = vega_wp_get_option('vega_wp_color_stylesheet');
    wp_enqueue_style('vega-wp-color', get_stylesheet_directory_uri() . '/color-schemes/' . strtolower($vega_wp_color_stylesheet) . '.css');
    
    // Load html5shiv.js
	wp_enqueue_script( 'vega-html5', get_template_directory_uri() . '/assets/js/html5shiv.js', array('vega-wp-style'), '3.7.0' );
	wp_script_add_data( 'vega-html5', 'conditional', 'lt IE 9' );
    // Load respond.min.js
	wp_enqueue_script( 'vega-respond', get_template_directory_uri() . '/assets/js/respond.min.js', array('vega-wp-style'), '1.3.0' );
	wp_script_add_data( 'vega-html5', 'conditional', 'lt IE 9' );
    
    /** Javascript **/
    
    #bootstrap
    wp_enqueue_script('bootstrap', get_template_directory_uri().'/assets/js/bootstrap.min.js', array('jquery'), '', true );
    wp_enqueue_script('jquery-smartmenus', get_template_directory_uri() . '/assets/js/jquery.smartmenus.min.js', array('jquery'), '', true );
    wp_enqueue_script('jquery-smartmenus-bootstrap', get_template_directory_uri() . '/assets/js/jquery.smartmenus.bootstrap.min.js', array('jquery'), '', true );
        
    #animation
    $vega_wp_animations = vega_wp_get_option('vega_wp_animations');
    if($vega_wp_animations == 'Y') {
        wp_enqueue_script('wow', get_template_directory_uri() . '/assets/js/wow.min.js', array('jquery'), '', true );
        wp_enqueue_script('vega-wp-themejs-anim', get_template_directory_uri() . '/assets/js/vega-wp-anim.js', array('jquery'), '', true );
    }
    
    #parallax
    wp_enqueue_script('parallax', get_template_directory_uri() . '/assets/js/parallax.min.js', array('jquery'), '', true );
    
    #theme javascript
    wp_enqueue_script('vega-wp-themejs', get_template_directory_uri() . '/assets/js/vega-wp.js', array('jquery'), '', true );
    
    #comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    
}
add_action( 'wp_enqueue_scripts', 'vega_wp_scripts' );


### CUSTOM CSS ###

function vega_wp_custom_css() {
    $vega_wp_custom_css = vega_wp_get_option('vega_wp_custom_css'); 
	echo '<!-- Custom CSS -->';
    $output="<style>" . stripslashes($vega_wp_custom_css) . "</style>";
    echo $output;
    echo '<!-- /Custom CSS -->';
}
add_action('wp_head','vega_wp_custom_css');


### CUSTOMIZER STYLES ("Upgrade to Pro") ###

function vega_wp_custom_customize_enqueue() {
    wp_enqueue_style( 'customizer-css', get_template_directory_uri() . '/customize/style.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'vega_wp_custom_customize_enqueue' );


### WIDGETS ###

function vega_wp_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'vega' ),
		'id'            => 'sidebar',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'vega' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer Col 1', 'vega' ),
		'id'            => 'footer_1',
		'description'   => __( 'Add widgets here to appear in the first column of the footer.', 'vega' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer Col 2', 'vega' ),
		'id'            => 'footer_2',
		'description'   => __( 'Add widgets here to appear in the second column of the footer.', 'vega' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer Col 3', 'vega' ),
		'id'            => 'footer_3',
		'description'   => __( 'Add widgets here to appear in the third column of the footer.', 'vega' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer Col 4', 'vega' ),
		'id'            => 'footer_4',
		'description'   => __( 'Add widgets here to appear in the fourth column of the footer.', 'vega' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'vega_wp_widgets_init' );


### INCLUDES ###

#bootstrap nav walker
require get_template_directory() . '/includes/wp_bootstrap_navwalker.php';
#customizer
require get_template_directory() . '/customize/customizer.php';


### FUNCTIONS ###


#vega_wp_title
if ( ! function_exists( 'vega_wp_title' ) ) :
function vega_wp_title() {
    $title = '';
    if( is_home() && get_option('page_for_posts') ) {
        $title = get_page( get_option('page_for_posts') )->post_title;
    }
    else if ( is_page() ) {
        $title = get_the_title(); if($title == '') $title = __("Page ID: ", 'vega') . get_the_ID();
    }
    else if ( is_single() ){
        $title = get_the_title(); if($title == '') $title = __("Post ID: ", 'vega') . get_the_ID();
    }
    else if ( is_category() ) {
        $title = single_cat_title('', false);
    }
    else if ( is_tag() ) {
        $title = single_tag_title(__('Tag: ', 'vega'), false);
    }
    else if ( is_author() ) {
        $title = __('Author: ', 'vega') . '<span>' . get_the_author() . '</span>';
    }
    else if ( is_day() ) {
        $title = __('Day: ', 'vega') . '<span>' . get_the_date() . '</span>';
    }
    else if ( is_month() ) {
        $title = __('Month: ', 'vega') . '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'vega' ) )  . '</span>';
    }
    else if ( is_year() ) {
        $title = __('Year: ', 'vega') . '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'vega' ) )  . '</span>';
    }
    else if ( is_404() ) {
        $title = __('Not Found!', 'vega');
    }
    else if ( is_search() ) {
        $title = __('Search Results: ', 'vega') . get_search_query();
    }
    else {
        $title = __( 'Archives', 'vega' );
    }
    
    return $title;
} 
endif;


#vega_wp_get_col_class
if ( ! function_exists( 'vega_wp_get_col_class' ) ) :
function vega_wp_get_col_class($n){
    switch($n){
        case 1: return 'col-md-12'; break;
        case 2: return 'col-md-6'; break;
        case 3: return 'col-md-4'; break;
        case 4: return 'col-md-3'; break;
    }
}
endif;


#vega_wp_get_option
if ( ! function_exists( 'vega_wp_get_option' ) ) :
function vega_wp_get_option($key){
    global $vega_wp_defaults;
    if (array_key_exists($key, $vega_wp_defaults)) 
        $value = get_theme_mod($key, $vega_wp_defaults[$key]); 
    else
        $value = get_theme_mod($key);
    return $value;
}
endif;

### EXAMPLE/DEFAULTs CONTENT ###

#vega_wp_rand_page
function vega_wp_rand_page() {
    $pages = get_pages();
    if(!empty($pages)) {    
        shuffle($pages);
        return $pages[0]->ID; 
    } else {
        return false;
    }
} 

#vega_wp_random_thumbnail
function vega_wp_random_thumbnail($size='default'){
    global $vega_wp_defaults;
    if($size == 'vega-post-thumbnail-recent')
        $images = $vega_wp_defaults['vega_wp_recent_post_image'];
    else if($size == 'full')
        $images = $vega_wp_defaults['vega_wp_full_image'];
    else 
        $images = $vega_wp_defaults['vega_wp_featured_image'];
    $rand_key = array_rand($images, 1);
    echo esc_url($images[$rand_key]);
}

#vega_wp_sequential_thumbnail
function vega_wp_sequential_thumbnail($size, $n){
    global $vega_wp_defaults;
    if($size == 'vega-post-thumbnail-recent')
        $images = $vega_wp_defaults['vega_wp_recent_post_image'];
    else 
        $images = $vega_wp_defaults['vega_wp_featured_image'];
    echo esc_url($images[$n]); 
}

#vega_wp_example_nav_header
function vega_wp_example_nav_header(){
    $args = array('parent'=>0);
    $pages = get_pages($args);
    
    echo '<div class="navbar-collapse collapse"><ul class="nav navbar-nav navbar-right menu-header">';
    
    $vega_wp_enable_demo = vega_wp_get_option('vega_wp_enable_demo');
    if(get_option('show_on_front') == 'page' || $vega_wp_enable_demo == 'Y') {
        
        #one page items    
        $vega_wp_frontpage_position_content = vega_wp_get_option('vega_wp_frontpage_position_content'); 
        $vega_wp_frontpage_position_4cols = vega_wp_get_option('vega_wp_frontpage_position_4cols'); 
        $vega_wp_frontpage_position_cta_dark = vega_wp_get_option('vega_wp_frontpage_position_cta_dark'); 
        $vega_wp_frontpage_position_cta_dark2 = vega_wp_get_option('vega_wp_frontpage_position_cta_dark2'); 
        $vega_wp_frontpage_position_open1 = vega_wp_get_option('vega_wp_frontpage_position_open1'); 
        $vega_wp_frontpage_position_latest_posts = vega_wp_get_option('vega_wp_frontpage_position_latest_posts'); 
        $arr[$vega_wp_frontpage_position_content] = 'content';
        $arr[$vega_wp_frontpage_position_4cols] = '4cols';
        $arr[$vega_wp_frontpage_position_cta_dark] = 'cta_dark';
        $arr[$vega_wp_frontpage_position_cta_dark2] = 'cta_dark2';
        $arr[$vega_wp_frontpage_position_open1] = 'open1';
        $arr[$vega_wp_frontpage_position_latest_posts] = 'latest_posts';
        
        ksort($arr);
        foreach($arr as $k=>$v){
            
            if($v == 'content') {   echo '<li class="page-scroll"><a href="#welcome">' . __('Welcome', 'vega') . '</a></li>'; }
            
            if($v == '4cols')   {   $vega_wp_frontpage_4_cols_section_id = vega_wp_get_option('vega_wp_frontpage_4_cols_section_id'); 
                                    $vega_wp_frontpage_4_cols_heading = vega_wp_get_option('vega_wp_frontpage_4_cols_heading');
                                    echo '<li class="page-scroll"><a href="#'.esc_attr($vega_wp_frontpage_4_cols_section_id).'">' . esc_html($vega_wp_frontpage_4_cols_heading) . '</a></li>'; }
            
            if($v == 'cta_dark'){   $vega_wp_frontpage_cta_dark_section_id = vega_wp_get_option('vega_wp_frontpage_cta_dark_section_id');  
                                    echo '<li class="page-scroll"><a href="#'.esc_attr($vega_wp_frontpage_cta_dark_section_id).'">' . esc_html($vega_wp_frontpage_cta_dark_section_id) . '</a></li>'; }
                                    
            if($v == 'cta_dark2'){   $vega_wp_frontpage_cta_dark2_section_id = vega_wp_get_option('vega_wp_frontpage_cta_dark2_section_id');  
                                    echo '<li class="page-scroll"><a href="#'.esc_attr($vega_wp_frontpage_cta_dark2_section_id).'">' . esc_html($vega_wp_frontpage_cta_dark2_section_id) . '</a></li>'; }
                                    
            if($v == 'latest_posts') {  $vega_wp_frontpage_latest_posts_section_id = vega_wp_get_option('vega_wp_frontpage_latest_posts_section_id');  
                                    $vega_wp_frontpage_latest_posts_heading = vega_wp_get_option('vega_wp_frontpage_latest_posts_heading');
                                    echo '<li class="page-scroll"><a href="#'.esc_attr($vega_wp_frontpage_latest_posts_section_id).'">' . esc_html($vega_wp_frontpage_latest_posts_heading) . '</a></li>'; }
                                    
            if($v == 'open1')   {   $vega_wp_frontpage_open1_section_id = vega_wp_get_option('vega_wp_frontpage_open1_section_id'); 
                                    $vega_wp_frontpage_open1_heading = vega_wp_get_option('vega_wp_frontpage_open1_heading');
                                    echo '<li class="page-scroll"><a href="#'.esc_attr($vega_wp_frontpage_open1_section_id).'">' . esc_html($vega_wp_frontpage_open1_heading) . '</a></li>'; }
        }
    }
    
    #all top level pages
    foreach($pages as $page) 
        echo '<li><a href="'.get_permalink($page->ID).'">'.esc_html($page->post_title).'</a></li>';
    echo '</ul>';
    echo '</div>';
}

#vega_wp_example_nav_footer
function vega_wp_example_nav_footer(){
    $args = array('parent'=>0);
    $pages = get_pages($args);
    echo '<ul id="menu-footer" class="nav-foot">';
    foreach($pages as $page) 
        echo '<li><a href="'.get_permalink($page->ID).'">'.esc_html($page->post_title).'</a></li>';
    echo '</ul>';
}

#vega_wp_example_frontpage_content
function vega_wp_example_frontpage_content(){
    $random_page_id = vega_wp_rand_page();
    $random_page = get_post( $random_page_id ); 
    echo '<h2 class="block-title wow zoomIn">' . esc_html($random_page->post_title) . '</h2>';
    echo '<div class="wow fadeInUp">'. $random_page->post_content .'</div>';
}

#vega_wp_example_sidebar_footer
function vega_wp_example_sidebar_footer(){
    echo '<div class="footer-widgets bg-grey-light-3">';
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-3 footer-widget footer-widget-col-1">';
    the_widget('WP_Widget_Pages', 'title=' . __('Pages', 'vega') , 'before_title=<h3 class="widget-title">&after_title=</h3>&before_widget=<div class="widget">&after_widget=</div>');
    echo '</div>';
    echo '<div class="col-md-3 footer-widget footer-widget-col-2">';
    the_widget('WP_Widget_Recent_Posts', 'title=' . __('Recent Posts', 'vega') , 'before_title=<h3 class="widget-title">&after_title=</h3>&before_widget=<div class="widget">&after_widget=</div>');
    echo '</div>';
    echo '<div class="col-md-3 footer-widget footer-widget-col-3">';
    the_widget('WP_Widget_Categories', 'title=' . __('Categories', 'vega') , 'before_title=<h3 class="widget-title">&after_title=</h3>&before_widget=<div class="widget">&after_widget=</div>');
    echo '</div>';
    echo '<div class="col-md-3 footer-widget footer-widget-col-3">';
    the_widget( 'WP_Widget_Meta', 'title=' . __('Meta', 'vega') , 'before_title=<h3 class="widget-title">&after_title=</h3>&before_widget=<div class="widget">&after_widget=</div>');
    echo '</div>';
    echo '</div></div></div>';
}

#vega_wp_example_sidebar
function vega_wp_example_sidebar(){
    echo '<div class="sidebar-widgets" >';
    the_widget('WP_Widget_Search');
    the_widget('WP_Widget_Pages', 'title=' . __('Pages', 'vega') , 'before_title=<h3 class="widget-title">&after_title=</h3>&before_widget=<div class="widget">&after_widget=</div>');
    the_widget('WP_Widget_Recent_Posts', 'title=' . __('Recent Posts', 'vega') , 'before_title=<h3 class="widget-title">&after_title=</h3>&before_widget=<div class="widget">&after_widget=</div>');
    the_widget( 'WP_Widget_Archives', 'title=' . __('Archives', 'vega'), 'before_title=<h3 class="widget-title">&after_title=</h3>&before_widget=<div class="widget">&after_widget=</div>');
    the_widget( 'WP_Widget_Categories', 'title=' . __('Categories', 'vega'), 'before_title=<h3 class="widget-title">&after_title=</h3>&before_widget=<div class="widget">&after_widget=</div>');
    echo '</div>';
}

?>