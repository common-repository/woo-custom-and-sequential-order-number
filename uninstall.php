<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * @link    https://codecanyon.net/item/woo-custom-and-sequential-order-number/18565141
 * @since   1.6.0
 * @package Woo Custom and Sequential Order Number 
 */
// If uninstall not called from WordPress, then exit.
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
{
        exit;
}

global $wpdb;

//remove options
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'wcson_%'" );


