<?php
/**
* The template part for displaying the post entry in the recent posts on the front page (static)
*
* @package vega
*/
?>
<?php
$vega_wp_blog_feed_meta = vega_wp_get_option('vega_wp_blog_feed_meta'); 
if($vega_wp_blog_feed_meta == 'Y') {
    $vega_wp_blog_feed_meta_author = vega_wp_get_option('vega_wp_blog_feed_meta_author'); 
    $vega_wp_blog_feed_meta_category = vega_wp_get_option('vega_wp_blog_feed_meta_category'); 
    $vega_wp_blog_feed_meta_date = vega_wp_get_option('vega_wp_blog_feed_meta_date'); 
}
$vega_wp_blog_feed_buttons = vega_wp_get_option('vega_wp_blog_feed_buttons'); 
global $key;
?>
<div class="post-grid recent-entry" id="recent-post-<?php the_ID(); ?>">
    <div class="recent-entry-image image">
        <?php if(has_post_thumbnail()) { ?>
        <a class="post-thumbnail post-thumbnail-recent" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'vega-post-thumbnail-recent', array( 'alt' => get_the_title(), 'class'=>'img-responsive' ) ); ?></a>
        <?php } else { ?>
        <a class="post-thumbnail post-thumbnail-recent" href="<?php the_permalink(); ?>"><img src="<?php vega_wp_random_thumbnail('vega-post-thumbnail-recent'); ?>" class="img-responsive" /></a><?php } ?>       
        <div class="caption">
            <div class="caption-inner">
                <a href="<?php the_permalink(); ?>" class="icon-link white"><i class="fa fa-link"></i></a>
            </div>
            <div class="helper"></div>
        </div>
    </div>
    <!-- Post Title -->
    <?php #if no title is defined for the post...
    if(get_the_title() == '') { $id = get_the_ID(); ?>
    <h4 class="recent-entry-title"><a href="<?php the_permalink(); ?>"><?php _e('ID: ', 'vega'); echo $id; ?></a></h4>
    <?php } else { ?>
    <h4 class="recent-entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    <?php } ?>
    <!-- /Post Title -->
    
    <div class="recent-entry-content">
        <?php the_excerpt(); ?>
    </div>
    
    <!-- Post Meta -->
    <div class="recent-entry-meta">
        <?php if($vega_wp_blog_feed_meta_date == 'Y') { $temp[] = __('Posted: ', 'vega') . get_the_date(); } ?>
        <?php if($vega_wp_blog_feed_meta_category == 'Y') { $temp[] = __('Under: ', 'vega'). get_the_category_list(', '); } ?>
        <?php if($vega_wp_blog_feed_meta_author == 'Y') { $temp[] = __('By: ', 'vega')  . get_the_author();  } ?>
        <?php if($temp) $str = implode('<span class="sep">/</span>', $temp) ?>
        <?php echo $str; $temp = array(); ?>
    </div>
    <!-- /Post Meta -->

    <?php if($vega_wp_blog_feed_buttons == 'Y') { ?>
    <!-- Post Buttons -->
    <div class="recent-entry-buttons">
        <a href="<?php the_permalink(); ?>" class="btn btn-primary-custom"><?php _e('Read More', 'vega'); ?></a>
        <?php if ( ! post_password_required() && comments_open() || '0' != get_comments_number() )  { ?> 
        <?php comments_popup_link( __( 'Leave comment', 'vega' ), __( '1 Comment', 'vega' ), esc_html__( '% Comments', 'vega' ), 'btn btn-inverse' ); ?></a>
        <?php } ?>
    </div>
    <!-- /Post Buttons -->
    <?php } ?>
    
</div>
