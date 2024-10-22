<?php
define( 'WP_CACHE', true );
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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u594770379_ENbpD' );

/** Database username */
define( 'DB_USER', 'u594770379_xlDFy' );

/** Database password */
define( 'DB_PASSWORD', 'KUpbaX9jW7' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '2[}2];^}Z.@=qu.L;{msml4p*HOL;wSVE!pI8!Mros0{)zw&Y/j=w;3T@lO6vKex' );
define( 'SECURE_AUTH_KEY',   '3N,0@S^DN{`2=h)Q0g+do{]*/Zbqjl{D58=RAi{vz]hynJ693IJ*u&(iU^N_JaeU' );
define( 'LOGGED_IN_KEY',     'Q:;JCt8.yKE^,v2K=c 63DK:24t^v4n6rSxx!d);%2R@J/d s(9e6> QCXCaNP|~' );
define( 'NONCE_KEY',         'VvSO$ GEp~jrr5}lq7B].A2-}F`{|8q8I9k+ZS~x`)^jaiM GGC 7c&U,YJ8G$;o' );
define( 'AUTH_SALT',         'S~#7Qq}3#_Cy~{R@6Cl.]T*?.+|[ Bp8xJPG!+UXuG@Ucr>}TT3dM64%Za^&4`;9' );
define( 'SECURE_AUTH_SALT',  'gllfFEJr{kJm1?^i`FfIS;M_#c_~z2g6@Li2_?2r5MUXNMl,Z:{Yq5Q )}`A2p1x' );
define( 'LOGGED_IN_SALT',    ' 9)]u~KXoe)dt@Eff&9^(sj?!N;CR1gZi=z}#M8n*#[h!NRO:Y2xuy(CN9KqO>kw' );
define( 'NONCE_SALT',        'mH2jm!Mo&?dpJ<^-+64u/5sSk_hHjoDc%+|3DJ#F`78gu2`O=Ix9ZCn r+cnuQ9&' );
define( 'WP_CACHE_KEY_SALT', 'jorg&XUw@]4(XT:&IOnxSu<qeGsxIQxQF8@5J;rK3O[DB.AAI*fTT&mp~0C]Az7o' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'c9ca47b124001ce8bc335424846c92a9' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
