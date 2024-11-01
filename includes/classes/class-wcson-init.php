<?php

if( !defined( 'ABSPATH' ) )
{
        die( __( "Can't load this file directly", "woo-custom-and-sequential-order-number" ) );
}

class WCSON_INIT
{

        public function __construct()
        {

                if( !function_exists( 'is_plugin_active_for_network' ) )
                {
                        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
                }

                $required_woo_plugin = 'woocommerce/woocommerce.php';

                $plugins = get_option( 'active_plugins' );

                if( in_array( $required_woo_plugin, $plugins ) || is_plugin_active_for_network( $required_woo_plugin ) )
                {

                        if( class_exists( 'Woocommerce' ) )
                        {
                                self::wcson_init_plugin();
                        }
                        else
                        {
                                add_action( 'woocommerce_loaded', [ __CLASS__, 'wcson_init_plugin' ] );
                        }
                }

                add_filter( 'plugin_action_links_' . plugin_basename( WCSON_PLUGIN_FILE ), [ $this, 'plugin_action_links' ] );

                unset( $plugins, $required_woo_plugin );
        }

        public static function wcson_init_plugin()
        {
                add_action( 'admin_init', [ __CLASS__, 'do_updates' ], 1 );

                add_action( 'plugins_loaded', [ __CLASS__, 'wcson_load_textdomain' ] );

                add_action( 'admin_enqueue_scripts', [ __CLASS__, 'wcson_set_admin_css' ], 10 );

                add_action( 'admin_enqueue_scripts', [ __CLASS__, 'wcson_set_admin_js' ], 10 );

                add_action( 'admin_menu', [ __CLASS__, 'wcson_set_menu' ] );

                add_action( 'admin_init', [ __CLASS__, 'wcson_db_check' ] );

                add_action( 'admin_head', [ __CLASS__, 'wcson_hide_all_notice_to_admin_side' ], 10000 );

                add_filter( 'admin_footer_text', [ __CLASS__, 'wcson_replace_footer_admin' ] );

                add_filter( 'update_footer', [ __CLASS__, 'wcson_replace_footer_version' ], '1234' );

        }

        public static function do_updates()
        {

                $installed_version = get_option( 'wcson_plugin_version' );

                // Maybe it's the first install.
                if( !$installed_version )
                {
                        return;
                }

                if( version_compare( $installed_version, '2.5.1', '<' ) )
                {
                        if( (!class_exists( "WCSON_ORDER_NUMBER" )) && file_exists( WCSON_CLASSES_DIR . '/class-wcson-order-number.php' ) )
                        {
                                require_once( WCSON_CLASSES_DIR . '/class-wcson-order-number.php' );
                        }

                        $orderNumberSetting = WCSON_ORDER_NUMBER::wcson_get_settings();

                        if( isset( $orderNumberSetting[ 'number_start_from' ] ) && !isset( $orderNumberSetting[ "currentNumber" ] ) )
                        {
                                $orderNumberSetting[ "currentNumber" ] = absint( $orderNumberSetting[ 'number_start_from' ] ) > 0 ? absint( $orderNumberSetting[ 'number_start_from' ] ) : 1;
                                $orderNumberSetting[ "currentNumberFree" ] = absint( $orderNumberSetting[ 'free_number_start_from' ] ) > 0 ? absint( $orderNumberSetting[ 'free_number_start_from' ] ) : 1;

                                unset( $orderNumberSetting[ 'number_start_from' ], $orderNumberSetting[ 'free_number_start_from' ] );

                                update_option( 'wcson_order_number_settings', maybe_serialize( $orderNumberSetting ) );
                        }
                }

                if( version_compare( $installed_version, WCSON_PLUGIN_VERSION, '<' ) )
                {
                        update_option( 'wcson_plugin_version', WCSON_PLUGIN_VERSION );
                }
        }

        public static function wcson_init_plugin_data()
        {

                $wcson_plugin_version = get_option( 'wcson_plugin_version' );

                if( !isset( $wcson_plugin_version ) || trim( $wcson_plugin_version ) === '' )
                {

                        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                        update_option( 'wcson_plugin_version', WCSON_PLUGIN_VERSION );

                        update_option( 'wcson_plugin_installation_date', time() );

                        update_option( 'wcson_order_number_settings', self::wcson_get_default_settings() );
                }
        }

        public static function wcson_get_default_settings()
        {

                return maybe_serialize( [
                        "wcson-order-number" => "WC-{number_start_from:1}-ORDER",
                        "wcson-free-order-number" => "WC-{number_start_from:1}-FREE-ORDER",
                        "wcson-free-order-number-check" => 0
                        ] );
        }

        /**
         * Show action links on the plugin screen.
         *
         * @param  mixed $links Plugin Action links.
         * @return array
         */
        public function plugin_action_links( $links = [] )
        {

                $plugin_links = [
                        '<a href="' . admin_url( "admin.php?page=wcson-order-number" ) . '">' . esc_html__( 'Settings', "woo-custom-and-sequential-order-number" ) . '</a>',
                ];

                return array_merge( $plugin_links, $links );
        }

        public static function wcson_db_check()
        {

                self::wcson_set_time_limit( 0 );

                self::wcson_init_plugin_data();
        }

        public static function wcson_load_textdomain()
        {
                load_plugin_textdomain( "woo-custom-and-sequential-order-number", false, 'woo-custom-and-sequential-order-number/languages/' );
        }

        public static function wcson_set_admin_css()
        {

                if( isset( $_REQUEST[ 'page' ] ) && ($_REQUEST[ 'page' ] == 'wcson-order-number') )
                {

                        wp_enqueue_style( 'wcson-admin-css', WCSON_CSS_URL . '/wcson-admin.min.css', [], WCSON_PLUGIN_VERSION );
                }
        }

        public static function wcson_set_admin_js()
        {

                wp_register_script( 'wcson-admin-js', WCSON_JS_URL . '/wcson-admin.min.js', [ 'jquery' ], WCSON_PLUGIN_VERSION, true );

                if( isset( $_REQUEST[ 'page' ] ) && (strtolower( trim( sanitize_text_field( $_REQUEST[ 'page' ] ) ) ) === 'wcson-order-number' ) )
                {

                        wp_enqueue_script( 'jquery' );

                        wp_enqueue_script( 'wcson-admin-js' );

                        $wcson_localize_script_data = [
                                'wcson_ajax_url' => admin_url( 'admin-ajax.php' ),
                                'wcson_site_url' => site_url(),
                                'upload_url' => WCSON_UPLOAD_URL,
                                'upload_dir' => WCSON_UPLOAD_DIR,
                                'plugin_url' => WCSON_PLUGIN_URL,
                                'i18n' => self::load_i18n()
                        ];

                        wp_localize_script( 'wcson-admin-js', 'wcson_plugin_settings', $wcson_localize_script_data );
                }
        }

        private static function load_i18n()
        {
                return [
                        "activateLicenseError" => __( 'Error While Activate License', "woo-custom-and-sequential-order-number" ),
                        "savingError" => __( 'Error During Saving', "woo-custom-and-sequential-order-number" )
                ];
        }

        public static function wcson_hide_all_notice_to_admin_side()
        {
                if( isset( $_REQUEST[ 'page' ] ) && (strtolower( trim( sanitize_text_field( $_REQUEST[ 'page' ] ) ) ) === 'wcson-order-number' ) )
                {
                        remove_all_actions( 'admin_notices', 10000 );
                        remove_all_actions( 'all_admin_notices', 10000 );
                        remove_all_actions( 'network_admin_notices', 10000 );
                        remove_all_actions( 'user_admin_notices', 10000 );
                }
        }

        public static function wcson_set_menu()
        {

                add_submenu_page( 'woocommerce', __( 'Order Number', "woo-custom-and-sequential-order-number" ), __( 'Order Number', "woo-custom-and-sequential-order-number" ), 'manage_options', 'wcson-order-number', [ __CLASS__, 'wcson_get_page' ] );
        }

        public static function wcson_get_page()
        {

                if( isset( $_REQUEST[ 'page' ] ) && strtolower( trim( sanitize_text_field( $_REQUEST[ 'page' ] ) ) ) === 'wcson-order-number' && file_exists( WCSON_VIEW_DIR . '/wcson-order-number.php' ) )
                {

                        require_once( WCSON_VIEW_DIR . '/wcson-order-number.php');
                }
        }

        public static function wcson_replace_footer_admin()
        {
                echo '';
        }

        public static function wcson_replace_footer_version()
        {
                return '';
        }

        public static function wcson_set_time_limit( $time = 0 )
        {

                $safe_mode = ini_get( 'safe_mode' );

                if( (!$safe_mode) || trim( strtolower( $safe_mode ) ) === 'off' )
                {
                        @set_time_limit( $time );
                        @ini_set( "memory_limit", "-1" );
                }
        }

}
