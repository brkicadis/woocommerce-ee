<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Wirecard AG and are explicitly not part
 * of the Wirecard AG range of products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License version 3 (GPLv3) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Wirecard AG does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Wirecard AG does not guarantee their full
 * functionality neither does Wirecard AG assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Wirecard AG does not guarantee the full functionality
 * for customized shop systems or installed plugins of other vendors of plugins within the same
 * shop system.
 *
 * Customers are responsible for testing the plugin's functionality before starting productive
 * operation.
 *
 * By installing the plugin into the shop system the customer agrees to these terms of use.
 * Please do not use the plugin if you do not agree to these terms of use!
 */

class WC_Cart {
	public $cart_contents;

	public function __construct() {
		$this->cart_contents = array(
			'1' => array(
				'data'       => new WC_Product(),
				'quantity'   => 1,
				'product_id' => 1,
			),
		);
	}

	public function get_cart() {
		return $this->cart_contents;
	}

	public function get_shipping_total() {
		return 5;
	}

	public function get_shipping_tax() {
		return 1;
	}

	public function get_quantity() {
		return 1;
	}

	public function get_cart_from_session() {
		return $this->cart_contents;
	}

	public function get_total() {
		return 50;
	}

	public function get_applied_coupons() {
		return array( 'test_coupon' );
	}

	public function get_coupon_discount_totals() {
		return array( 'test_coupon' => 12 );
	}

	public function get_coupon_discount_tax_totals() {
		return array( 'test_coupon' => 1 );
	}
}
