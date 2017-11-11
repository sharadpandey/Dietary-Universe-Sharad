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
define('DB_NAME', 'db697469436');

/** MySQL database username */
define('DB_USER', 'dbo697469436');

/** MySQL database password */
define('DB_PASSWORD', 'Im@rk123#@');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '`Qkt |g-YFKt!MUZuOi^x5uBR<k.rI:/A+I>,^YFYtz={p^eavqJ$X@[ GyIF(N$');
define('SECURE_AUTH_KEY',  'YGVEGT{E9OD:,2W_x@3Kj`KuAcH4`CFTjw<%}25$Hjs#j1#wp<nlWR]}J.<}EI8v');
define('LOGGED_IN_KEY',    'XjOxq&NY=mq4qRcc6[!g;s}-rHLQ[nSkSoB?!RK Pky2G-9l1)Y?X9El[~?1<m~_');
define('NONCE_KEY',        ' aSpeymdR,X8(^HhG#Njk}0_L;]j@wx!v!6=7B}`Hi]qm]OOc[o <6jD~/l HdOx');
define('AUTH_SALT',        'EPoH.5>_YEsZqX;}b8hd<sKPRX;,E/ZlW*s+6A_B#:d OtZQ#?F7mqhH2A/r(5d]');
define('SECURE_AUTH_SALT', '),4A,_1u]TFTs{gSjM+tI_XRz#]0aN7b}n)?BF^lP)w.Rbldx2bd9QZVi4HrAydc');
define('LOGGED_IN_SALT',   ';N<Yg0Nm}qxX/odFf%%%`KNQ}R.j48H~JJtOT;bzIW*k)QfX.%ILc@1&K&H2jDsE');
define('NONCE_SALT',       'rv,NaN2x^kVat<!Y&;j6lQ,wyW8sy!8f=`QY+/0_!)iau4~W[D=~vE6):#f,<k!C');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
