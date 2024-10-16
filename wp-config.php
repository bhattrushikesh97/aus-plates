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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "ausplates1" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

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
define( 'AUTH_KEY',         ')@x`z_w-.YUnZNG%&(UfWEUG}wE$lX$CD1mIqPQf$P;(&7?)1a%Bu2?6nFBS*YK)' );
define( 'SECURE_AUTH_KEY',  'iwZnvL-p+07/D#YSQ=xp9_4afN;`h250?#l%ERB;8QQ%wZ,=D:`cm +b$b6PiLgl' );
define( 'LOGGED_IN_KEY',    ':=MH*}wEOp2~@.4k;Qin?Y@9%ckMH7tL40w~J1ii7h)sukk?W< VJm7w$5VPelhc' );
define( 'NONCE_KEY',        '4%H:lxPG0d5H-)EIc7,}z`~Y0QSX;Zu00%_=Yy_hP)1E*+5,`mc;~1 VAhZ}C=Di' );
define( 'AUTH_SALT',        'Xya@yBShh@pr?_4AJp=g?+M~NC-L.6k`:8&J<:kVH-;D+)htz,E]>C|,EPvV+)Gx' );
define( 'SECURE_AUTH_SALT', '==?Mg[u+w$,J641uZjf}y3^/QzP3Qo2K/,<>4N&q+&iNqY0]>y2+.vi!I~3w]XUD' );
define( 'LOGGED_IN_SALT',   'rZr DdNo#J}[lx71zwqKCuOk^oez]C`#pAEvO^1K.=JK.7%0#D#K,1iSX.F/,>5p' );
define( 'NONCE_SALT',       '?&JxA1enRwUhA{+[N[fycy?hocz>{@l~]>^oPPxyNTb+h(RU_5e2%qs=G7vtjoM~' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
