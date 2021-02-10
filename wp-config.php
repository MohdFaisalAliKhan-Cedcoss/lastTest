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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'uhSbuQSES8Z+83IvjtptQzKsLNGpFVEoRro4z1kbPccZA4bLOiYuEXqXRK/cZzGEfxhpJLxjv/7lYBc5MBgWMA==');
define('SECURE_AUTH_KEY',  'vtQ8W7f984ACK+/2tP9yJKNv/u9X90JQKIHuvmICRoyhdS3x1xJEBXM+jyTBE+C1vhQoE0V66FKh7y1LAwy8nA==');
define('LOGGED_IN_KEY',    'S/XuMUQhFHEl9Jy0i1BS+1Jx1gkrtAQqCgx4/SXC7caPODmaFLN7389qVlor+yVhwhkOwfnZCgNKHMld9qtN1A==');
define('NONCE_KEY',        'ncn+fDUzZhmijh4s7HrllXbBLDlJUKBrjj2qfWFpsvNkROtN5BOKtVs0ejHSj0qvjy3rEb7W1/Ne6onIEjwgaQ==');
define('AUTH_SALT',        'trQAK6/hg9uAXQmyLBFYmJ9AV44BiNqhhiT1PVes7avWxygTexwAI3B5D0fz8fx3rzGVJ/umup8GPbTzCNPa9g==');
define('SECURE_AUTH_SALT', 'z7PER6D0tngVTPijiUacg3mW75kfiW975nr73y+1nlvf5uruZjXTOj7WqDmlw9V9x5dSzEfz/H4ZQ6DDvk/RSw==');
define('LOGGED_IN_SALT',   'a9hEKAaVIhDcflAOfnymGZroTcdq+ai3NQQct+pPg4avI0gzKpoLwb5ig+Vwx0q3OFkviU5//0JdarBH2uy56w==');
define('NONCE_SALT',       'r/cgspUXqOyA3YBRCEteYcgEctGVCtlLvc5+/JK2gj7FpNKzoBmFAFB9ffUv06p+1ePK1b5W5xn+H9fbdENLwA==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
