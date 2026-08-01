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
define( 'DB_NAME', 'u923418691_qgT2I' );

/** Database username */
define( 'DB_USER', 'u923418691_eaWV2' );

/** Database password */
define( 'DB_PASSWORD', 'IBV4HYy8qA' );

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
define( 'AUTH_KEY',          'OGo^aeusa4 CTpJ~c!X/:_Kd;ZQqh[#/XFPAA250A>14A*Rh8iV[>ZzfkGqc:  R' );
define( 'SECURE_AUTH_KEY',   '7tGDR@%JF{Xq|aHwEhZLu}PX,[k[|w`j}a+~(Who+i[)^F$T&H/]t8$_ojxVr-@t' );
define( 'LOGGED_IN_KEY',     '<ZA9.?Fiq:n+$=R<LLwOtAM=8Z:/IPxCZSH:q2ZpNEI7c%}#cN{W_j$CZly[Ikc6' );
define( 'NONCE_KEY',         '~%xcyM>DDlic3,j*a~5&Rb1)u<2t2A$$:D*k(/;*etyQ^zrSC.+}Kwo_P(jNXNM5' );
define( 'AUTH_SALT',         'em$_~zrFJQSs[ooD-)8o4Z7u1eAtqB,+DbuJX!Z7}KXwdu638SbLM&.v_fEY[&<K' );
define( 'SECURE_AUTH_SALT',  '2Gjb/-A`KR{aT4EBVr03kJmN+4VJMFIQ2G9c+]&/uTO;U[g?CQEEnWPDD*~eIO!0' );
define( 'LOGGED_IN_SALT',    'E`vTT>VS!*Tv8ujFuy4Wxi^$&rL$(8s,3?9{M,f4|$HdV8m@[@N^:Q@MRi[$P6DN' );
define( 'NONCE_SALT',        '@o$Y}6Vk.*`#Mswe.o?fijrI8r2l5giGfSFqHMUx_Q~OY`0wdlt24pUa9K0{]uQb' );
define( 'WP_CACHE_KEY_SALT', '[o{MC{svDq}HdUs-/mfWAd3Amt%HJO@mYPjCbjh1K4630k/qC{@!-2$],( sJu-)' );


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



define( 'WP_AUTO_UPDATE_CORE', 'minor' );
define( 'FS_METHOD', 'direct' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
