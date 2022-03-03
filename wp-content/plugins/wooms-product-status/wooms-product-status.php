<?php
/**
 * Plugin Name: WooMS Product Status
 * Plugin URI: https://t.me/dmfaas
 * Description: Provides extended wooms integration with configurable statuses for new imported products.
 * Version: 5.7
 */

define('WOOMS_PRODUCT_STATUS_OPTION_NAME', 'wooms_new_product_status');

add_action('admin_init', 'wooms_product_status_settings_general', 99);
function wooms_product_status_settings_general() {
    register_setting('mss-settings', WOOMS_PRODUCT_STATUS_OPTION_NAME);
    add_settings_field(
        'wooms_new_product_status',
        'Статус для новых продуктов',
        'display_wooms_new_product_status_setting_field',
        'mss-settings',
        'woomss_section_other'
    );
}

function display_wooms_new_product_status_setting_field() {
    $current_value = get_option(WOOMS_PRODUCT_STATUS_OPTION_NAME); ?>
    <select name="wooms_new_product_status">
        <?php foreach ( get_post_statuses() as $status => $title ) {
            $selected = $current_value === $status ? 'selected="selected"' : null; ?>
            <option <?php print $selected; ?> value='<?php print esc_attr( $status ); ?>'><?php print $title?></option>
        <?php } ?>
    </select>
    <?php
}

register_activation_hook( __FILE__, 'wooms_product_status_activate' );
register_deactivation_hook( __FILE__, 'wooms_product_status_deactivate' );

function wooms_product_status_activate() {
    update_option(WOOMS_PRODUCT_STATUS_OPTION_NAME, 'publish');
}

function wooms_product_status_deactivate() {
    delete_option(WOOMS_PRODUCT_STATUS_OPTION_NAME);
}

add_action('wooms_product_data_item', 'wooms_product_status_product_data_item', -10);
function wooms_product_status_product_data_item($value) {
    if ( ! empty( $value['archived'] ) ) {
        return;
    }

    /**
     * Если отключена опция связи по UUID и пустой артикул, то пропуск записи
     */
    if ( empty(get_option('wooms_use_uuid')) and empty($value['article']) ) {
        return;
    }

    //попытка получить id по артикулу
    if ( ! empty( $value['article'] ) ) {
        $product_id = wc_get_product_id_by_sku( $value['article'] );
    } else {
        $product_id = null;
    }

    $transient_key = wooms_product_status_data_item_transient_id($value);
    if ($product_id) {
        delete_transient($transient_key);
    } else {
        set_transient($transient_key, 1, 120);
    }
}

add_filter('wooms_product_save', 'wooms_product_status_product_save', 40, 2);
function wooms_product_status_product_save($product, $data_api) {
    /** @var WC_Product_Simple $product */

    $transient_key = wooms_product_status_data_item_transient_id($data_api);
    $is_new_product = !empty(get_transient($transient_key));

    // Takes original status from data (get_status return value including changes),
    // because default filter callback always overriding status to 'publish'.
    $status = $is_new_product
        ? get_option(WOOMS_PRODUCT_STATUS_OPTION_NAME)
        : $product->get_data()['status'];

    $product->set_status($status);

    return $product;
}

function wooms_product_status_data_item_transient_id($data_api) {
    $data = [];

    foreach (['id', 'article'] as $key) {
        if (!empty($data_api[$key])) {
            $data[] = $data_api[$key];
        }
    }

    return sprintf('wooms_product_%s_is_new', implode('_', $data));
}

function wooms_product_status_include_post_status_value_for_product_search($query) {
    /** @var WP_Query $query */
    $vars = $query->query_vars;

    // temporary hack.
    $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 200);
    $functions = array_column($trace, 'function');

    if (in_array('get_product_id_by_uuid', $functions, true)
        && $vars['post_type'] === 'product'
        && $vars['meta_key'] === 'wooms_id'
        && !empty($vars['meta_value'])) {
        $query->set('post_status', 'any');
    }
}
add_action( 'pre_get_posts', 'wooms_product_status_include_post_status_value_for_product_search' );
