<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kmc_wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'secret' );

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
define( 'AUTH_KEY',         '7l^&Cbj#,R^T_Zh L=7tDN>bNLFpdhoK{#3VE0<nd e>nyp1[_vJT.;m|(<AQBQU' );
define( 'SECURE_AUTH_KEY',  'd4]`XsuBQ9iwJcg@mf5/%UA`c!OWMd7<{pQ;SVGi{Jo.LbuG__6v!Jb$7UU/duBp' );
define( 'LOGGED_IN_KEY',    'Je~e^ 5+JL|#|ZS*#Ee>p7b<ijyq@+$A[$!cKkuW4W)6rU>&6&Uz~~J{Nlv~13rn' );
define( 'NONCE_KEY',        '{>c;m!VOY`K^?q7&YZKEB4~kRNFw~Outbmxc`w.*R(N6Yy?Sa5H3J&&AU|:1oY(j' );
define( 'AUTH_SALT',        '3}9wzOb]C5tGADWg_e;/NMQNfr; FLmW}Rv|6Y%i.;;(7@!dSWdMYIl,38j+ /Mx' );
define( 'SECURE_AUTH_SALT', '4 LnyPAN{Pi 4#3yz~_Rj~gKC[Xlop@bEtxk#n3XjqDSi3k#~9mzv!)6t},|pd{{' );
define( 'LOGGED_IN_SALT',   '9=v7C=M(PR7yvf2?OG#jbJlRj@GOMMbf?n;c-Q%IFYPGa:A#jB@^HUbmbi>kVs@a' );
define( 'NONCE_SALT',       '&7L@Ff:yxcXqC*kLPLu!jp!YAPGQP-fIj!f`ft9x&?`60*^z:,!}t#U>vuL9c!(z' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

define('FS_METHOD', 'direct');
