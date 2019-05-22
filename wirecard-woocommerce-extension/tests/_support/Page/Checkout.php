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

namespace Page;

use \Codeception\Util\Locator;

class Checkout extends Base {

	// include url of current page
	/**
	 * @var string
	 * @since 1.4.4
	 */
	public $URL = '/checkout';

	/**
	 * @var array
	 * @since 1.4.4
	 */
	public $elements = array(
		'First Name'                    		=> "//*[@id='billing_first_name']",
		'Last Name'                     		=> "//*[@id='billing_last_name']",
		'Country'                       		=> "//*[@id='select2-billing_country-container']",
		'Country entry'                 		=> "//*[@class='select2-search__field']",
		'Country entry selected'        		=> "//*[@class='select2-results']",
		'Street address'                		=> "//*[@id='billing_address_1']",
		'Town/City'                     		=> "//*[@id='billing_city']",
		'Postcode'                      		=> "//*[@id='billing_postcode']",
		'Phone'                         		=> "//*[@id='billing_phone']",
		'Email address'                 		=> "//*[@id='billing_email']",
		'Place order'                   		=> "//*[@id='place_order']",
		'Wirecard PayPal' 						=> "//*[@id='payment']/ul/li[2]",
		'Credit Card First Name'        		=> "//*[@id='pp-cc-first-name']",
		'Credit Card Last Name'         		=> "//*[@id='pp-cc-last-name']",
		'Credit Card Card number'      		 	=> "//*[@id='pp-cc-account-number']",
		'Credit Card CVV'               		=> "//*[@id='pp-cc-cvv']",
		'Credit Card Valid until month / year' 	=> "//*[@id='pp-cc-expiration-date']",
		'Pay now'								=> "//*[@id='seamless-submit']"
	);

	/**
	 * Method fillBillingDetails
	 *
	 * @since   1.4.4
	 */
	public function fillBillingDetails() {
		$I                 = $this->tester;
		$data_field_values = $I->getDataFromDataFile( 'tests/_data/CustomerData.json' );
		$I->waitForElementVisible( $this->getElement( 'First Name' ) );
		$I->fillField( $this->getElement( 'First Name' ), $data_field_values->first_name );
		//Explicit wait times to avoid flakiness
		$I->wait( 2 );
		$I->waitForElementVisible( $this->getElement( 'Last Name' ) );
		$I->fillField( $this->getElement( 'Last Name' ), $data_field_values->first_name );
		$I->wait( 2 );
		$I->waitForElementVisible( $this->getElement( 'Country' ) );
		$I->click( $this->getElement( 'Country' ) );
		$I->fillField( $this->getElement( 'Country entry' ), $data_field_values->country );
		$I->wait( 2 );
		$I->click( $this->getElement( 'Country entry selected' ) );
		$I->wait( 2 );
		$I->waitForElementVisible( $this->getElement( 'Street address' ) );
		$I->fillField( $this->getElement( 'Street address' ), $data_field_values->street_address );
		$I->wait( 2 );
		$I->waitForElementVisible( $this->getElement( 'Town/City' ) );
		$I->fillField( $this->getElement( 'Town/City' ), $data_field_values->town );
		$I->wait( 2 );
		$I->waitForElementVisible( $this->getElement( 'Postcode' ) );
		$I->fillField( $this->getElement( 'Postcode' ), $data_field_values->post_code );
		$I->wait( 2 );
		$I->waitForElementVisible( $this->getElement( 'Phone' ) );
		$I->fillField( $this->getElement( 'Phone' ), $data_field_values->phone );
		$I->wait( 2 );
		$I->waitForElementVisible( $this->getElement( 'Email address' ) );
		$I->fillField( $this->getElement( 'Email address' ), $data_field_values->email_address );
	}
	/**
	 * Method fillCreditCardDetails
	 * @since   1.4.4
	 */
	public function fillCreditCardDetails() {
		$I                 = $this->tester;
		$data_field_values = $I->getDataFromDataFile( 'tests/_data/CardData.json' );
		$I->wait(5);
		$this->switchFrame();
		$I->waitForElementVisible( $this->getElement( 'Credit Card Last Name' ) );
		$I->fillField( $this->getElement( 'Credit Card Last Name' ), $data_field_values->last_name );
		$I->fillField( $this->getElement( 'Credit Card Card number' ), $data_field_values->card_number );
		$I->fillField( $this->getElement( 'Credit Card CVV' ), $data_field_values->cvv );
		$I->fillfield(
			$this->getElement( "Credit Card Valid until month / year" ),
			$data_field_values->valid_until_month
			.substr( $data_field_values->valid_until_year, -2 )
		);
		$I->switchToIFrame();
	}

	/**
	 * Method switchFrame
	 * @since   1.4.4
	 */
	public function switchFrame() {
		 // Switch to Credit Card UI frame
		$I = $this->tester;
		//wait for Javascript to load iframe and it's contents
		$I->wait( 2 );
		//get wirecard seemless frame name
		$wirecard_frame_name = $I->executeJS( 'return document.querySelector("#wirecard-integrated-payment-page-frame").getAttribute("name")' );
		$I->switchToIFrame( "$wirecard_frame_name" );
	}
}
