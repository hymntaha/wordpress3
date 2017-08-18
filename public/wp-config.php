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
require_once(ABSPATH . 'wp-database-settings.php');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'w}fif6sN5=`H?cOdn;uc?`Nr]AdyEuQc9lJ.z>gILa@l!F!IiD7BGA]SB~;C+JTV');
define('SECURE_AUTH_KEY',  '0^6}0T4}vrs^z&Z,L6Cmq>_W<DY?cjT_K79M8ct&MgA!1Zf+E@VJ$(WP<]]]1my]');
define('LOGGED_IN_KEY',    'I7^`6r`fVoFY{B6 ASt;?E_(%=%+i=BQ9|0S]3=0Qh|6O/8u?wKb9#**<c(0_0){');
define('NONCE_KEY',        'J9piwQv7&fCS,AjJQCdZ&k&I73qW}c]2`nRqHw)4oCcj*XQXvA~GQ:Fha;C1[OvH');
define('AUTH_SALT',        'ijk{SFkLR?D78(1=dws^sD;9ex@(;$Lc:N^{18F?[x6>)G!wEM4BMegT> D{)x$9');
define('SECURE_AUTH_SALT', '}?_^k@M0MigDI%1w||97&0})te} Wq3KA6n,YJ@+GTC2^rVq_e0]Oq4&jpNg97~~');
define('LOGGED_IN_SALT',   'e?+)UN%Jg4l1QpGUL;$B06Kdy}.zl6MY1X^ :++7<QZ>uXqf~;_3Lh@!JKfI)VR=');
define('NONCE_SALT',       'n*T#+_> ]3JJ{%P:,m-S_677P{X9d={Gwl[T8yJ6^upFeYy`o<2Rj$sx8_hm2qSo');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'geo_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
