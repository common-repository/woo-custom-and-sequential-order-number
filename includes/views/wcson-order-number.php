<?php
if( !defined( 'ABSPATH' ) )
{
        die( __( "Can't load this file directly", "woo-custom-and-sequential-order-number" ) );
}

$wcson_order_number_settings = WCSON_ORDER_NUMBER::wcson_get_settings();

$wcson_free_order_number_check = isset( $wcson_order_number_settings[ 'wcson-free-order-number-check' ] ) ? sanitize_text_field( $wcson_order_number_settings[ 'wcson-free-order-number-check' ] ) : "";

$disply_style = "";

if( $wcson_free_order_number_check == 1 )
{
        $disply_style = "display:block;";
}

?>
<div class="wcson-container-wrapper">
        <form class="wcson-order-number-frm">
                <div class="wcson-container-inner-wrapper">
                        <div class="wcson-header-title">
                            <?php esc_html_e( 'Manage Order Number', "woo-custom-and-sequential-order-number" ); ?>
                                <div class="wcson-upgrade-to-premium"><a class="wcson-general-btn" target="_blank" href="https://1.envato.market/ZWEMX"><?php _e( 'Upgrade To Premium', "woo-custom-and-sequential-order-number" ); ?></a></div>
                        </div>
                        <div class="wcson-success-msg"></div>
                        <div class="wcson-settings-container">
                                <div class="wcson-form-label"><?php esc_html_e( 'Enter Order Number', "woo-custom-and-sequential-order-number" ); ?></div>
                                <div class="wcson-form-input-wrapper" >
                                        <input type="text" class="wcson-form-input wcson-order-number" name="wcson-order-number" value="<?php echo isset( $wcson_order_number_settings[ 'wcson-order-number' ] ) ? esc_attr( $wcson_order_number_settings[ 'wcson-order-number' ] ) : ""; ?>"/>
                                        <div class="wcson-hint-content">
                                                <div class="wpson_hint_wrapper">
                                                        <div class="wcson-hint-content-title"><?php esc_html_e( 'Variables', "woo-custom-and-sequential-order-number" ); ?></div>
                                                        <div class="wcson-hint-content-data">
                                                                <table class="wcson_table"  cellpadding="10" cellspacing="0">
                                                                        <tr>
                                                                                <th class="wpson_sample_title"><?php esc_html_e( 'Variable', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                                <th class="wpson_sample_content"><?php esc_html_e( 'Description', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{order_id}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'Order Id', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{number_start_from:101}</td>
                                                                                <td class="wpson_sample_content"><?php esc_html_e( 'Start Number From 101', "woo-custom-and-sequential-order-number" ); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{date:Y}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'Order Date with Date format. YYYY is date Format.', "woo-custom-and-sequential-order-number" ); ?>&nbsp; <?php esc_html_e( 'Note : please refere', "woo-custom-and-sequential-order-number" ); ?> <a target="new" href="http://php.net/manual/en/function.date.php" ><?php esc_html_e( 'here', "woo-custom-and-sequential-order-number" ); ?></a> <?php esc_html_e( 'For Date Format', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><br /><span><strong><?php esc_html_e( 'Sample Date Formats', "woo-custom-and-sequential-order-number" ); ?></strong></span>
                                                                                        <br /><br /><table class="wcson_table_date_format"  cellpadding="10" cellspacing="0">
                                                                                                <tr>
                                                                                                        <th><?php esc_html_e( 'Format', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                                                        <th><?php esc_html_e( 'Value', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td>{date:Y-m-d}</td>
                                                                                                        <td>2021-02-22</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td>{date:Y}</td>
                                                                                                        <td>2021</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td>{date:m}</td>
                                                                                                        <td>02</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td>{date:d}</td>
                                                                                                        <td>22</td>
                                                                                                </tr>
                                                                                        </table>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{custom-field:my-order-custom-field}</td>
                                                                                <td class="wpson_sample_content"><?php esc_html_e( 'Order Custom Fields.', "woo-custom-and-sequential-order-number" ); ?><span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{increment:5}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'Order number Increment by specific value.', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'Note : work only if {number_start_from:(your chosen number)} variable found in order number.', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'For Example : {number_start_from:100}{increment:10}', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{even_number}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'For only EVEN order numbers', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'Note : work only if {number_start_from:(your chosen number)} variable found in order number.', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'For Example : {number_start_from:200}{even_number}', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{odd_number}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'For only ODD order numbers', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'Note : work only if {number_start_from:(your chosen number)} variable found in order number.', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'For Example : {number_start_from:200}{odd_number}', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                </td>
                                                                        </tr>
                                                                </table>
                                                        </div>
                                                </div>
                                                <div class="wpson_hint_wrapper wpson_example_hint_wrapper">
                                                        <div class="wcson-hint-content-title"><?php esc_html_e( 'Examples', "woo-custom-and-sequential-order-number" ); ?></div>
                                                        <div class="wcson-hint-content-data">
                                                                <table class="wcson_table"  cellpadding="10" cellspacing="0"> 
                                                                        <tr>
                                                                                <th class="wpson_sample_title"><?php esc_html_e( 'Sample format', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                                <th class="wpson_sample_content"><?php esc_html_e( 'Order number', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA-{order_id}-ZZ</td>
                                                                                <td class="wpson_sample_content">AA-101-ZZ</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA {number_start_from:1} MM {order_id} ZZ</td>
                                                                                <td class="wpson_sample_content">AA 1 MM 101 ZZ</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">ORDER-{date:Y-m-d}</td>
                                                                                <td class="wpson_sample_content">ORDER-2017-12-31</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">ORDER-{custom-field:max-price}</td>
                                                                                <td class="wpson_sample_content">ORDER-999</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA-{number_start_from:100}{increment:10}-ZZ</td>
                                                                                <td class="wpson_sample_content">AA-100-ZZ, AA-110-ZZ, AA-120-ZZ,....</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA-{number_start_from:200}{even_number}-ZZ</td>
                                                                                <td class="wpson_sample_content">AA-200-ZZ, AA-202-ZZ, AA-204-ZZ,....</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA-{number_start_from:0001}{odd_number}-ZZ</td>
                                                                                <td class="wpson_sample_content">AA-0001-ZZ, AA-0003-ZZ, AA-0005-ZZ,....</td>
                                                                        </tr>
                                                                </table>
                                                        </div>
                                                </div>
                                        </div>
                                </div>

                        </div>
                        <div class="wcson-settings-container">
                                <div class="wcson-form-label"><?php esc_html_e( 'Use different numeration for free orders', "woo-custom-and-sequential-order-number" ); ?></div>
                                <div class="wcson-form-input-wrapper" >
                                        <input type="checkbox" class="wcson-form-input-check wcson-free-order-number-check" name="wcson-free-order-number-check" value="1" <?php checked( $wcson_free_order_number_check, 1 ); ?>/>
                                        <div class="wcson_pro_notice"><?php esc_html_e( '(Premium Feature)', "woo-custom-and-sequential-order-number" ); ?></div>
                                        <div class="wcson-hint-content">
                                                <div class="wcson-hint-content-title"><?php esc_html_e( 'Use different numeration for free orders', "woo-custom-and-sequential-order-number" ); ?></div>
                                                <div class="wcson-hint-content-data"><?php esc_html_e( 'If this option has been activated, you can use a different numeration for your free orders.', "woo-custom-and-sequential-order-number" ); ?></div>
                                        </div>
                                </div>
                        </div>
                        <div class="wcson-settings-container wcson-free-order-number-wrapper" style="<?php echo $disply_style; ?>">
                                <div class="wcson-form-label"><?php esc_html_e( 'Enter Free Order Number', "woo-custom-and-sequential-order-number" ); ?></div>
                                <div class="wcson-form-input-wrapper" >
                                        <input type="text" class="wcson-form-input wcson-free-order-number" name="wcson-free-order-number" value="<?php echo isset( $wcson_order_number_settings[ 'wcson-free-order-number' ] ) ? esc_attr( $wcson_order_number_settings[ 'wcson-free-order-number' ] ) : ""; ?>"/>
                                        <div class="wcson-hint-content">
                                                <div class="wpson_hint_wrapper">
                                                        <div class="wcson-hint-content-title"><?php esc_html_e( 'Variables', "woo-custom-and-sequential-order-number" ); ?></div>
                                                        <div class="wcson-hint-content-data">
                                                                <table class="wcson_table"  cellpadding="10" cellspacing="0">
                                                                        <tr>
                                                                                <th class="wpson_sample_title"><?php esc_html_e( 'Variable', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                                <th class="wpson_sample_content"><?php esc_html_e( 'Description', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{order_id}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'Order Id', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{number_start_from:101}</td>
                                                                                <td class="wpson_sample_content"><?php esc_html_e( 'Start Number From 101', "woo-custom-and-sequential-order-number" ); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{date:Y}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'Order Date with Date format. YYYY is date Format.', "woo-custom-and-sequential-order-number" ); ?>&nbsp; <?php esc_html_e( 'Note : please refere', "woo-custom-and-sequential-order-number" ); ?> <a target="new" href="http://php.net/manual/en/function.date.php" ><?php esc_html_e( 'here', "woo-custom-and-sequential-order-number" ); ?></a> <?php esc_html_e( 'For Date Format', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><br /><span><strong><?php esc_html_e( 'Sample Date Formats', "woo-custom-and-sequential-order-number" ); ?></strong></span>
                                                                                        <br /><br /><table class="wcson_table_date_format"  cellpadding="10" cellspacing="0">
                                                                                                <tr>
                                                                                                        <th><?php esc_html_e( 'Format', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                                                        <th><?php esc_html_e( 'Value', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td>{date:Y-m-d}</td>
                                                                                                        <td>2021-02-22</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td>{date:Y}</td>
                                                                                                        <td>2021</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td>{date:m}</td>
                                                                                                        <td>02</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td>{date:d}</td>
                                                                                                        <td>22</td>
                                                                                                </tr>
                                                                                        </table>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{custom-field:my-order-custom-field}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'Order Custom Fields.', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{increment:5}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'Order number Increment by specific value.', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'Note : work only if {number_start_from:(your chosen number)} variable found in order number.', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'For Example : {number_start_from:100}{increment:10}', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{even_number}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'For only EVEN order numbers', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'Note : work only if {number_start_from:(your chosen number)} variable found in order number.', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'For Example : {number_start_from:200}{even_number}', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">{odd_number}</td>
                                                                                <td class="wpson_sample_content">
                                                                                        <?php esc_html_e( 'For only ODD order numbers', "woo-custom-and-sequential-order-number" ); ?>
                                                                                        <span class="wcson-premium-info"><?php esc_html_e( '( Premium Feature )', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'Note : work only if {number_start_from:(your chosen number)} variable found in order number.', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                        <br /><span class="wpson_setting_notice"><?php esc_html_e( 'For Example : {number_start_from:200}{odd_number}', "woo-custom-and-sequential-order-number" ); ?></span>
                                                                                </td>
                                                                        </tr>
                                                                </table>
                                                        </div>
                                                </div>
                                                <div class="wpson_hint_wrapper wpson_example_hint_wrapper">
                                                        <div class="wcson-hint-content-title"><?php esc_html_e( 'Examples', "woo-custom-and-sequential-order-number" ); ?></div>
                                                        <div class="wcson-hint-content-data">
                                                                <table class="wcson_table"  cellpadding="10" cellspacing="0"> 
                                                                        <tr>
                                                                                <th class="wpson_sample_title"><?php esc_html_e( 'Sample format', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                                <th class="wpson_sample_content"><?php esc_html_e( 'Order number', "woo-custom-and-sequential-order-number" ); ?></th>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA-{order_id}-ZZ</td>
                                                                                <td class="wpson_sample_content">AA-101-ZZ</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA {number_start_from:1} MM {order_id} ZZ</td>
                                                                                <td class="wpson_sample_content">AA 1 MM 101 ZZ</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">ORDER-{date:Y-m-d}</td>
                                                                                <td class="wpson_sample_content">ORDER-2017-12-31</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">ORDER-{custom-field:max-price}</td>
                                                                                <td class="wpson_sample_content">ORDER-999</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA-{number_start_from:100}{increment:10}-ZZ</td>
                                                                                <td class="wpson_sample_content">AA-100-ZZ, AA-110-ZZ, AA-120-ZZ,....</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA-{number_start_from:200}{even_number}-ZZ</td>
                                                                                <td class="wpson_sample_content">AA-200-ZZ, AA-202-ZZ, AA-204-ZZ,....</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="wpson_sample_title">AA-{number_start_from:0001}{odd_number}-ZZ</td>
                                                                                <td class="wpson_sample_content">AA-0001-ZZ, AA-0003-ZZ, AA-0005-ZZ,....</td>
                                                                        </tr>
                                                                </table>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                        <div class="wcson-btn-wrapper">
                                <div class="wcson-general-btn wcson-save-settings-btn"><?php esc_html_e( 'Save', "woo-custom-and-sequential-order-number" ); ?></div>
                                <div class="wcson-save-loader-wrapper"><img  class="wcson-save-loader" src="<?php echo esc_url( WCSON_IMAGES_URL . '/wcson-loader.gif' ); ?>"/></div>
                        </div>
                </div>
        </form>
</div>
<div class="wcson-documantation-links-wrapper">
        <div class="wcson-documantation-links-outer">
                <a target="_blank" href="<?php echo WCSON_PLUGIN_URL . '/documentation/'; ?>"><?php esc_html_e( 'Documentation', "woo-custom-and-sequential-order-number" ); ?></a> |  <a target="_blank" href="http://www.vjinfotech.com/support"><?php esc_html_e( 'Support', "woo-custom-and-sequential-order-number" ); ?></a>
        </div>
</div>
<?php
unset( $wcson_order_number_settings, $wcson_free_order_number_check, $disply_style, $plugin_all_data, $unlock_style, $lock_style );
