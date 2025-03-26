<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'custom-checkout' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'm8(M(C1g::1F|MhycGf[4[ugV:O1oaP[,GZs54L5^{^vR-m)*15GWk|~:fjE3Yi7' );
define( 'SECURE_AUTH_KEY',  'k`2@590*^(6C/drt/d,:TQMVMy}od%c/o2R`eA!%DV]aMZ)k[=Jf@EIPhwmoK %@' );
define( 'LOGGED_IN_KEY',    'GCygaB2>JCfU{Z#;F VBnQQcfcoCb.s}C~W,]#g$je_+t/a[4hKRPppSNNkG8[k&' );
define( 'NONCE_KEY',        'x7bW7ep :^8okZhog~}aj,y[fy0,5eVGK[a9s~98(s@0[FIX&_gPq?VQ4!!O[WVo' );
define( 'AUTH_SALT',        ':?#;/B~.K={<jBKTe|J!HoM(0hEwubf_a<k_}C@o&oKvbL`Lt<]sF=#S&>v|8MR*' );
define( 'SECURE_AUTH_SALT', '} poUbhC v=)PCTEM`pcB)_U:f{c#jHonME!l=P9J+Fw$uK;NuW$2)[d9/d6_}.k' );
define( 'LOGGED_IN_SALT',   ',$,M3cz nsqE4{20p{0|}Cyevi-l9@|=MR%?nnC)wM.P^G7y;D+]ou!i E+Z4d,a' );
define( 'NONCE_SALT',       '5H@890*wp.VC3{5k!eK$zRr%t=o1sS2*A>*=6Q@eGO I?zuE[t6oaBr]4xV(M]fW' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define( 'FS_METHOD', 'direct' );



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
