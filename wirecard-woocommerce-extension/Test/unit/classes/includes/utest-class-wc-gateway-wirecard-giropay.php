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

require_once __DIR__ . '/../../../../classes/includes/class-wc-gateway-wirecard-giropay.php';

/**
 * Class WC_Gateway_Wirecard_Giropay_Utest
 * @coversDefaultClass WC_Gateway_Wirecard_Giropay
 */
class WC_Gateway_Wirecard_Giropay_Utest extends \PHPUnit_Framework_TestCase
{

	/** @var WC_Gateway_Wirecard_Giropay */
	private $payment;

	/**
	 * Initialize mock class
	 */
	public function setUp()
	{
		$this->payment = new WC_Gateway_Wirecard_Giropay();
		$_POST['giropay_bank_bic'] = 'GENODETT488';
		$_POST['giropay_nonce'] = 'test';
	}

	/**
	 * @group unit
	 * @small 
	 * @covers ::init_form_fields
	 */
	public function test_init_form_fields()
	{
		$this->payment->init_form_fields();
		$formFields = $this->payment->form_fields;
		
		$this->assertTrue(is_array($formFields));
		$this->assertArrayHasKey('title', $formFields);
		$this->assertArrayHasKey('enabled', $formFields);
		$this->assertArrayHasKey('merchant_account_id', $formFields);
		$this->assertArrayHasKey('secret', $formFields);
		$this->assertArrayHasKey('base_url', $formFields);
		$this->assertArrayHasKey('http_user', $formFields);
		$this->assertArrayHasKey('http_pass', $formFields);
		$this->assertArrayHasKey('test_button', $formFields);
	}

	/**
	 * @group unit
	 * @small
	 * @covers ::process_payment
	 */
	public function test_process_payment()
	{
		$result = $this->payment->process_payment(12);
		$this->assertTrue(is_array($result));
		$this->assertArrayHasKey('result', $result);
	}

	/**
	 * @group unit
	 * @small
	 * @covers ::payment_fields
	 */
	public function test_payment_fields()
	{
		$this->assertTrue($this->payment->payment_fields());
	}
}
