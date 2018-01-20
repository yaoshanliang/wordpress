<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

//关闭小版本的自动更新
define( 'AUTOMATIC_UPDATER_DISABLED', true );


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '=s!:`*TF]&f,gBV/UEK@1>vmEIp$m{EThvnC6~bX7e]g9Cu_fTMO_$G^cY(`Qu~Y');
define('SECURE_AUTH_KEY',  ';]fx$ 4)M<f*U8U;f}~0_dfL}<|Tc-B$M1t3#Qkjp6l)9EE-SYQV?5`UgMPsq;}^');
define('LOGGED_IN_KEY',    's>]xebJ>=f*Zi)g[DVE,UZ:l;ew%}HD7#{=P`?57R]<}A5phSN{hYrk1X>9eBNv*');
define('NONCE_KEY',        '_{^b<|_+D41s_f`vn yc.}z@bp!=o3;mNDC<`gs!N0aKcPvwv~[f[`*V*i*(IoD8');
define('AUTH_SALT',        '_&KLYr>b;blo~c{T(F+d|q :vv;ZFUvIry|x(mJX<.>r<6VDvC^**)9V~IzfY%vo');
define('SECURE_AUTH_SALT', 'sLwt;1>-1U|#AT5HuPVc[ -mMwkyGEsm4]&meU6F)Ca#^6s-w,Go$UAuW_gCGocB');
define('LOGGED_IN_SALT',   'QN}g1Gsq[X:BPT [iKTr{Qc>EX=?d;~<TLH{:qSECF>br yBFj-!v$!Iq&yV|:~C');
define('NONCE_SALT',       '$j(^q6)L$p`c`C3,~E%07HS2JdD&y0wVop9h!Dj2.a2Tb:CBILIPRu,A2tH%a eK');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);


define('WPLANG','zh_CN');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

//屏蔽 WP 后台“显示选项”和“帮助”选项卡
function remove_screen_options(){ return false;}
add_filter('screen_options_show_screen', 'remove_screen_options');
add_filter( 'contextual_help', 'wpse50723_remove_help', 999, 3 );
function wpse50723_remove_help($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}

add_filter('pre_site_transient_update_core',    create_function('$a', "return null;")); // 关闭核心提示
add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;")); // 关闭插件提示
add_filter('pre_site_transient_update_themes',  create_function('$a', "return null;")); // 关闭主题提示
remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新
remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
remove_action('admin_init', '_maybe_update_themes');  // 禁止 WordPress 更新主题

//屏蔽后台页脚版本信息
function change_footer_admin () {return '';}
add_filter('admin_footer_text', 'change_footer_admin', 9999);
function change_footer_version() {return '';}
add_filter( 'update_footer', 'change_footer_version', 9999);


//屏蔽后台左上LOGO
function annointed_admin_bar_remove() {
    global $wp_admin_bar;
    /* Remove their stuff */
    $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);



function wp_hide_nag() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action('admin_menu','wp_hide_nag');
