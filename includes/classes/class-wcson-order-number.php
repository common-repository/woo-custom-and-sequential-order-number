<?php

if ( !defined( 'ABSPATH' ) )
{
        die( __( "Can't load this file directly", "woo-custom-and-sequential-order-number" ) );
}

class WCSON_ORDER_NUMBER
{

        private static $wcson_new_order_number_meta = '_wcson_order_number';
        private static $orderId = null;
        private static $pattern = '';
        private static $currentNumber = 0;
        private static $incrementBy = 1;
        private static $incrementOnly = false;
        private static $oddOnly = false;
        private static $evenOnly = false;

        public function __construct()
        {

                add_action( 'woocommerce_checkout_update_order_meta', [ __CLASS__, 'wcson_order_number' ], 10, 2 );

                add_action( 'woocommerce_process_shop_order_meta', [ __CLASS__, 'wcson_order_number' ], 35, 2 );

                add_action( 'woocommerce_before_resend_order_emails', [ __CLASS__, 'wcson_order_number' ], 10, 2 );

                add_action( 'woocommerce_api_create_order', [ __CLASS__, 'wcson_order_number' ], 10, 2 );

                add_action( 'woocommerce_deposits_create_order', [ __CLASS__, 'wcson_order_number' ], 10, 2 );

                add_filter( 'woocommerce_order_number', [ __CLASS__, 'wcson_get_order_number' ], 10, 2 );

                add_filter( 'woocommerce_shortcode_order_tracking_order_id', [ __CLASS__, 'wcson_find_order_by_order_number' ] );

                if ( self::wcson_check_wc_subscriptions_version() )
                {

                        add_filter( 'wcs_renewal_order_meta_query', [ __CLASS__, 'wcson_subscriptions_remove_renewal_order_meta' ] );

                        add_filter( 'wcs_renewal_order_created', [ __CLASS__, 'wcson_generate_subscriptions_new_order_number' ], 10, 2 );
                } else
                {
                        add_filter( 'woocommerce_subscriptions_renewal_order_meta_query', [ __CLASS__, 'wcson_subscriptions_remove_renewal_order_meta' ], 10, 4 );

                        add_action( 'woocommerce_subscriptions_renewal_order_created', [ __CLASS__, 'wcson_generate_subscriptions_new_order_number' ], 10, 4 );
                }

                if ( is_admin() )
                {

                        add_action( 'wp_ajax_wcson_save_settings', [ __CLASS__, 'wcson_save_settings' ] );

                        add_filter( 'request', [ __CLASS__, 'wcson_wc_custom_orderby_number' ], 10 );

                        add_filter( 'woocommerce_shop_order_search_fields', [ __CLASS__, 'wcson_add_new_custom_search_fields' ] );

                        add_filter( 'wc_pre_orders_search_fields', [ __CLASS__, 'wcson_add_new_custom_search_fields' ] );

                        add_filter( 'wc_pre_orders_edit_pre_orders_request', [ __CLASS__, 'wcson_custom_orderby_number' ] );
                }
        }

        public static function wcson_order_number( $post_id = 0, $post = "" )
        {

                if ( is_array( $post ) || is_null( $post ) || ( 'shop_order' === $post->post_type && 'auto-draft' !== $post->post_status ) )
                {

                        $order_number = get_post_meta( $post_id, self::$wcson_new_order_number_meta, true );

                        if ( '' === trim( $order_number ) )
                        {

                                self::wcson_generate_new_order_number( $post_id );
                        }
                }
        }

        public static function wcson_get_order_number( $order_id = 0, $order = [] )
        {

                $order_number = $order_id;

                if ( absint( $order_id ) !== 0 )
                {
                        $new_order_number = get_post_meta( $order_id, self::$wcson_new_order_number_meta, true );
                        if ( trim( $new_order_number ) !== "" )
                        {
                                $order_number = $new_order_number;
                        }
                }
                return $order_number;
        }

        public static function wcson_find_order_by_order_number( $order_number = "" )
        {

                // search for the order by custom order number
                $query_args = array(
                        'numberposts' => 1,
                        'meta_key' => self::$wcson_new_order_number_meta,
                        'meta_value' => $order_number,
                        'post_type' => 'shop_order',
                        'post_status' => 'any',
                        'fields' => 'ids',
                );

                $posts = get_posts( $query_args );

                if ( is_array( $posts ) && isset( $posts[ 0 ] ) && !empty( $posts[ 0 ] ) )
                {
                        return $posts[ 0 ];
                }

                $order = wc_get_order( $order_number );

                if ( !$order )
                {
                        return 0;
                }

                $new_order_number = get_post_meta( $order->get_id(), self::$wcson_new_order_number_meta, true );

                if ( trim( $new_order_number ) !== "" )
                {
                        return 0;
                }

                return $order->get_id();
        }

        public static function wcson_add_new_custom_search_fields( $search_fields = [] )
        {

                $search_fields[] = self::$wcson_new_order_number_meta;

                return $search_fields;
        }

        public static function wcson_generate_new_order_number( $orderId = 0 )
        {

                $orderNumberSetting = self::wcson_get_settings();

                $numberMeta = "currentNumber";

                $pattern = isset( $orderNumberSetting[ 'wcson-order-number' ] ) ? sanitize_text_field( $orderNumberSetting[ 'wcson-order-number' ] ) : "";

                $currentNumber = isset( $orderNumberSetting[ $numberMeta ] ) ? sanitize_text_field( $orderNumberSetting[ $numberMeta ] ) : 0;

                if ( empty( $pattern ) )
                {
                        return $orderId;
                }

                self::$pattern = $pattern;
                self::$orderId = $orderId;
                self::$currentNumber = $currentNumber;
                self::parsePattern();

                $orderNumberSetting[ $numberMeta ] = self::$currentNumber;

                update_option( 'wcson_order_number_settings', maybe_serialize( $orderNumberSetting ) );

                update_post_meta( self::$orderId, self::$wcson_new_order_number_meta, self::$pattern );

                return self::$pattern;
        }

        private static function parsePattern()
        {

                self::parseOrderId();

                self::parseDate();

                self::parseCf();

                self::parseIncrement();

                self::parseOdd();

                self::parseEven();

                self::parseNumber();
        }

        private static function parseOrderId()
        {
                if ( strpos( self::getPatternKey(), "{order_id" ) === false )
                {
                        return;
                }

                self::$pattern = preg_replace( "/({order_id)(.*?)(})/i", "", self::$pattern );
        }

        private static function parseDate()
        {
                if ( strpos( self::getPatternKey(), "{date:" ) === false )
                {
                        return;
                }

                self::$pattern = preg_replace( "/({date)(.*?)(})/i", "", self::$pattern );
        }

        private static function parseCf()
        {
                if ( strpos( self::getPatternKey(), "{custom-field:" ) === false )
                {
                        return;
                }

                self::$pattern = preg_replace( "/({custom-field)(.*?)(})/i", "", self::$pattern );
        }

        private static function parseNumber()
        {
                if ( strpos( self::getPatternKey(), "{number_start_from:" ) !== false )
                {
                        $startPos = intval( strpos( self::getPatternKey(), "{number_start_from:", 0 ) + 19 );

                        $endPos = intval( strpos( self::getPatternKey(), "}", $startPos ) - $startPos );

                        $number = substr( self::getPatternKey(), $startPos, $endPos );

                        $numnerLength = strlen( $number );

                        $number = absint( $number ) > 0 ? absint( $number ) : 1;

                        if ( self::$currentNumber === 0 )
                        {
                                self::$currentNumber = $number;
                        }

                        $finalNumber = self::$currentNumber;

                        do
                        {
                                if ( self::$oddOnly )
                                {
                                        $finalNumber = self::toOdd( $finalNumber );
                                } elseif ( self::$evenOnly )
                                {
                                        $finalNumber = self::toEven( $finalNumber );
                                }

                                $finalNumber = str_pad( $finalNumber, $numnerLength, 0, STR_PAD_LEFT );

                                $tempPattern = preg_replace( "/({number_start_from)(.*?)(})/i", $finalNumber, self::$pattern );

                                if ( self::isNumberExists( $tempPattern ) )
                                {
                                        $finalNumber = absint( $finalNumber ) + self::$incrementBy;
                                } else
                                {
                                        self::$currentNumber = absint( $finalNumber );
                                        break;
                                }
                        } while ( true );

                        self::$pattern = preg_replace( "/({number_start_from)(.*?)(})/i", $finalNumber, self::$pattern );
                } else
                {
                        self::parseEmptyNumber();
                }
        }

        private static function parseEmptyNumber()
        {

                $pattern = self::$pattern;

                $increment = 1;

                do
                {

                        if ( self::isNumberExists( $pattern ) )
                        {

                                $pattern = self::$pattern . '-' . $increment;
                        } else
                        {
                                break;
                        }
                        $increment++;
                } while ( true );

                self::$pattern = $pattern;
        }

        private static function parseIncrement()
        {
                if ( strpos( self::getPatternKey(), "{increment:" ) === false )
                {
                        return;
                }

                self::$pattern = preg_replace( "/({increment)(.*?)(})/i", "", self::$pattern );
        }

        private static function parseOdd()
        {
                if ( strpos( self::getPatternKey(), "{odd_number" ) === false )
                {
                        return;
                }
                self::$pattern = preg_replace( "/({odd_number)(.*?)(})/i", "", self::$pattern );
        }

        private static function parseEven()
        {
                if ( strpos( self::getPatternKey(), "{even_number" ) === false )
                {
                        return;
                }

                self::$pattern = preg_replace( "/({even_number)(.*?)(})/i", "", self::$pattern );
        }

        private static function toEven( $num = 0 )
        {
                $num = absint( $num ) < 2 ? 2 : absint( $num );

                if ( $num % 2 != 0 )
                {
                        $num++;
                }

                return $num;
        }

        private static function toOdd( $num = 0 )
        {
                $num = absint( $num ) < 1 ? 1 : absint( $num );

                if ( $num % 2 == 0 )
                {
                        $num++;
                }

                return $num;
        }

        private static function isNumberExists( $num = "" )
        {
                if ( empty( $num ) )
                {
                        return false;
                }

                global $wpdb;

                $id = $wpdb->get_var(
                        $wpdb->prepare(
                                "SELECT COUNT(posts.ID) FROM 
                                {$wpdb->posts} AS posts
                                INNER JOIN 
                                {$wpdb->postmeta} AS postmeta 
                                ON posts.ID=postmeta.post_id
                                WHERE
                                posts.post_type = 'shop_order'
                                AND postmeta.meta_key = %s
                                AND postmeta.meta_value = %s
                                ORDER BY posts.ID ASC
                                LIMIT 0, 1",
                                self::$wcson_new_order_number_meta,
                                $num
                        )
                );

                if ( absint( $id ) > 0 )
                {
                        return true;
                }

                return false;
        }

        private static function getPatternKey()
        {

                return strtolower( preg_replace( '/\s+/', '', self::$pattern ) );
        }

        public static function wcson_save_settings()
        {

                $NewSettings = [
                        'wcson-order-number' => isset( $_POST[ 'wcson-order-number' ] ) ? sanitize_text_field( $_POST[ 'wcson-order-number' ] ) : "",
                        'wcson-free-order-number' => isset( $_POST[ 'wcson-free-order-number' ] ) ? sanitize_text_field( $_POST[ 'wcson-free-order-number' ] ) : "",
                        'wcson-free-order-number-check' => ""
                ];

                $OldSettings = self::wcson_get_settings();

                if ( isset( $OldSettings[ 'wcson-order-number' ] ) && !empty( $OldSettings[ 'wcson-order-number' ] ) && trim( $OldSettings[ 'wcson-order-number' ] ) === trim( $NewSettings[ 'wcson-order-number' ] ) )
                {
                        $NewSettings[ 'currentNumber' ] = isset( $OldSettings[ 'currentNumber' ] ) ? absint( $OldSettings[ 'currentNumber' ] ) : 0;
                }

                update_option( 'wcson_order_number_settings', maybe_serialize( $NewSettings ) );

                echo json_encode( array( 'message' => 'success', 'message_content' => __( 'Settings Saved Successfully', "woo-custom-and-sequential-order-number" ) ) );

                die();
        }

        public static function wcson_get_settings()
        {

                $wcson_order_number_settings = get_option( 'wcson_order_number_settings', WCSON_INIT::wcson_get_default_settings() );

                return maybe_unserialize( $wcson_order_number_settings );
        }

        public static function wcson_is_order_free( $order_id = 0 )
        {

                if ( absint( $order_id ) === 0 )
                {
                        return false;
                }

                $order = wc_get_order( $order_id );

                if ( $order && $order->get_total() != "" && absint( $order->get_total() ) > 0 )
                {
                        return false;
                }

                return true;
        }

        public static function wcson_subscriptions_remove_renewal_order_meta( $order_meta_query )
        {
                return $order_meta_query . " AND meta_key NOT IN ( '" . self::$wcson_new_order_number_meta . "' )";
        }

        public static function wcson_check_wc_subscriptions_version()
        {

                if ( class_exists( 'WC_Subscriptions' ) && !empty( WC_Subscriptions::$version ) )
                {

                        $subscriptions_version = WC_Subscriptions::$version;

                        return $subscriptions_version && version_compare( $subscriptions_version, '2.0-beta-1', '>=' );
                }

                return false;
        }

        public static function wcson_generate_subscriptions_new_order_number( $renewal_order, $original_order )
        {

                $order_post = get_post( $renewal_order->id );

                self::wcson_generate_new_order_number( $order_post->ID, $order_post );

                if ( self::wcson_check_wc_subscriptions_version() )
                {
                        return $renewal_order;
                }
        }

        public static function wcson_custom_orderby_number( $args )
        {

                if ( isset( $args[ 'orderby' ] ) && 'ID' == $args[ 'orderby' ] )
                {

                        $args = array_merge( $args, [
                                'meta_key' => self::$wcson_new_order_number_meta,
                                'orderby' => 'meta_value_num',
                                ] );
                }

                return $args;
        }

        public static function wcson_wc_custom_orderby_number( $data )
        {

                global $typenow;

                if ( 'shop_order' === strtotime( trim( $typenow ) ) )
                {
                        return $data;
                }

                return self::wcson_custom_orderby_number( $data );
        }

}
