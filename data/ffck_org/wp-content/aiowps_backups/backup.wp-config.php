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
define('DB_NAME', 'ffck');

/** MySQL database username */
define('DB_USER', 'ffck');

/** MySQL database password */
define('DB_PASSWORD', 'FF-6SUgU6Wa9nF35LjzMxY873ub9CgZ6q');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'f#RTDcIq&Y50wnhOSkKyga,-+``Ap,mO!~L=:tu-RoBca4J.4>pF^MD<>&h7#BF+');
define('SECURE_AUTH_KEY',  'JY w$U2%8RyHL4P9xcf|(5-o3b?@07S-t>THGUN;th.Gswe`$.Wg0sH]a>c|evFA');
define('LOGGED_IN_KEY',    'fAWW&rL+(.3yTR!tR*EODoTzb8(N1e]bvlMy l5lCW(F~*`D>[hHN`nuN.!1[Px?');
define('NONCE_KEY',        'xXlN%m_*kYm4tK!n?_E5i1:PV^Tu2Z*AXhp7VR5+>8WK$Fpx+sCF _8T]ORQm2uB');
define('AUTH_SALT',        '=(bfK8ir;%}/S(V([`|72dZN3C_W?j.#WNSYg6hzzu5DM$*?vwwB)8z_m48:gI|e');
define('SECURE_AUTH_SALT', 'M>^#)=h>76[<m_(j$nmEvQ{W`a&T2&S[$e-,I<|;=?|&JL)O1`5SfN736LNnx-Xc');
define('LOGGED_IN_SALT',   '3+-z V(%9 |J/{D4`_mlw)rxJxIL/L|r|LsoDuseSI`n2i]`.oF-dT#6 Z80dZeO');
define('NONCE_SALT',       'xC$ MMBro +QVG4_jAh8|(8.zGf$7 @vTe$GD3WdB>.$,Tw#c9j[G--ortj=|2A^');


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
define('WP_MEMORY_LIMIT', '96M');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');