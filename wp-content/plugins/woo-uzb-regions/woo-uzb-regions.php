<?php
/**
 * Plugin Name:       WooCommerce Uzbekistan Regions
 * Plugin URI:        https://clickmarket.uz/
 * Description:       Плагин под WooCommerce.  Подключает регионы для Узбекистана в настройках доставки и на странице оформления заказа
 * Version:           1.0
 * Author:            Asadbek Ibragimov
 * Author URI:        https://asadbek-ibragimov.uz/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:
 * Domain Path:
 *
 * WC requires at least: 3.3.0
 * WC tested up to: 3.3.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_filter( 'woocommerce_states', 'awrr_states_uzbekistan' );
function awrr_states_uzbekistan( $states ) {
	$states['UZ'] = array(
		'01' => 'Город Ташкент',
        '02' => 'Ташкентская область',
        '03' => 'Андижанская область',
        '04' => 'Бухарская область',
        '05' => 'Джизакская область',
        '06' => 'Кашкадарьинская область',
        '07' => 'Навоийская область',
        '08' => 'Наманганская область',
        '09' => 'Самаркандская область',
        '10' => 'Сурхандарьинская область',
        '11' => 'Сырдарьинская область',
        '12' => 'Ферганская область',
        '13' => 'Хорезмская область',
        '14' => 'Республика Каракалпакстан',
	);
	return $states;
}