<?php

/*
  Plugin Name: Woo Custom and Sequential Order Number
  Description: Generates Custom and Sequential Order Numbers for WooCommerce Store Orders
  Version: 2.6.0
  Author: VJInfotech
  Author URI: http://www.vjinfotech.com
  Text Domain: woo-custom-and-sequential-order-number
  Domain Path: /languages/
  WC tested up to: 5.1

 */

if ( !defined( 'ABSPATH' ) )
{
        die( __( "Can't load this file directly", "woo-custom-and-sequential-order-number" ) );
}
// Plugin version
if ( !defined( 'WCSON_PLUGIN_VERSION' ) )
{
        define( 'WCSON_PLUGIN_VERSION', '2.6.0' );
}

// Plugin base name
if ( !defined( 'WCSON_PLUGIN_FILE' ) )
{
        define( 'WCSON_PLUGIN_FILE', __FILE__ );
}

// Plugin Folder Path
if ( !defined( 'WCSON_PLUGIN_DIR' ) )
{
        define( 'WCSON_PLUGIN_DIR', realpath( plugin_dir_path( WCSON_PLUGIN_FILE ) ) . '/' );
}

$plugin_url = plugin_dir_url( WCSON_PLUGIN_FILE );

if ( is_ssl() )
{
        $plugin_url = str_replace( 'http://', 'https://', $plugin_url );
}
if ( !defined( 'WCSON_PLUGIN_URL' ) )
{
        define( 'WCSON_PLUGIN_URL', $plugin_url );
}

if ( !defined( 'WCSON_ASSETS_URL' ) )
{
        define( 'WCSON_ASSETS_URL', WCSON_PLUGIN_URL . '/assets' );
}

if ( !defined( 'WCSON_CSS_URL' ) )
{
        define( 'WCSON_CSS_URL', WCSON_ASSETS_URL . '/css' );
}

if ( !defined( 'WCSON_JS_URL' ) )
{
        define( 'WCSON_JS_URL', WCSON_ASSETS_URL . '/js' );
}

if ( !defined( 'WCSON_IMAGES_URL' ) )
{
        define( 'WCSON_IMAGES_URL', WCSON_ASSETS_URL . '/images' );
}

if ( !defined( 'WCSON_INCLUDES_DIR' ) )
{
        define( 'WCSON_INCLUDES_DIR', WCSON_PLUGIN_DIR . '/includes' );
}

if ( !defined( 'WCSON_CLASSES_DIR' ) )
{
        define( 'WCSON_CLASSES_DIR', WCSON_INCLUDES_DIR . '/classes' );
}

if ( !defined( 'WCSON_VIEW_DIR' ) )
{
        define( 'WCSON_VIEW_DIR', WCSON_INCLUDES_DIR . '/views' );
}

// Plugin site path
if ( !defined( 'WCSON_PLUGIN_SITE' ) )
{
        define( 'WCSON_PLUGIN_SITE', 'http://www.vjinfotech.com' );
}

$wpupload_dir = wp_upload_dir();

$wcson_upload_dir = $wpupload_dir[ 'basedir' ] . '/woo-custom-and-sequential-order-number';

$wcson_upload_url = $wpupload_dir[ 'baseurl' ] . '/woo-custom-and-sequential-order-number';

define( 'WCSON_UPLOAD_DIR', $wcson_upload_dir );

define( 'WCSON_UPLOAD_URL', $wcson_upload_url );

wp_mkdir_p( $wcson_upload_dir );

if ( file_exists( WCSON_CLASSES_DIR . '/class-wcson-init.php' ) )
{
        require_once( WCSON_CLASSES_DIR . '/class-wcson-init.php' );
}

if ( file_exists( WCSON_CLASSES_DIR . '/class-wcson-order-number.php' ) )
{
        require_once( WCSON_CLASSES_DIR . '/class-wcson-order-number.php' );
}

new WCSON_INIT();

new WCSON_ORDER_NUMBER();

