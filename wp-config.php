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
define( 'DB_NAME', 'intanjayakab' );

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
define( 'AUTH_KEY',         'e9KB~,Tk3rHs.Mrnf[LFui@h?,W(<`y2H26XBFW}v$}5J<x=V9<NTb39&kd.`<&n' );
define( 'SECURE_AUTH_KEY',  '4DXe`[UwA@=$/keV}%Fc!Lx6>]P@~A=HzRB9Ei/,}gkSmm)43B!h7 [BQICzKoT@' );
define( 'LOGGED_IN_KEY',    'bq_CN+`G?wz6$8L>j&1#a,+w4eOQ97IO4A}EE>q*G}La5RO~g?6gRDn8lux0~e!`' );
define( 'NONCE_KEY',        '7YM)RDN+9>GzM_5M&Fp!!]#qpaBUUD[HuY>9&aE(F?`EJ#[DsX8EX<#%v*AWak=U' );
define( 'AUTH_SALT',        'c.b{xcIBi0Z8<VrQBv~bL)I,aT pdX~W$i8rU?l__i.`u!Kp2=9n#z@mG$fqEMvQ' );
define( 'SECURE_AUTH_SALT', '@WBW`0#gI2aq/7>&Y:0m?O q??VT?-:}mdH).{d^9;88JQlhlp~8#afsYAs%iL3B' );
define( 'LOGGED_IN_SALT',   ')y4r31=an*[/&^/;dYr]e@7;nx=Z5<8*SbAD*f&mtj#[WNMw@77:K.N7%ko|*@G$' );
define( 'NONCE_SALT',       '|FIZ!7OeW2}{La+pF#=Se!:fLXlA)n0$V~Vb@hyzq5RS$o$}ow$w;%YAd~GOz|12' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
