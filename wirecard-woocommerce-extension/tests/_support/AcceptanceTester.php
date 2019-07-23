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

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */

use Helper\Acceptance;
use Helper\PhpBrowserAPITest;
use Page\Base;
use Page\Cart as CartPage;
use Page\Checkout as CheckoutPage;
use Page\Product as ProductPage;
use Page\Shop as ShopPage;
use Page\OrderReceived as OrderReceivedPage;
use Page\Verified as VerifiedPage;
use Page\PayPalLogIn as PayPalLogInPage;
use Page\PayPalReview as PayPalReviewPage;

class AcceptanceTester extends \Codeception\Actor {

	use _generated\AcceptanceTesterActions;

	/**
	 * @var string
	 * @since 1.4.4
	 */
	private $currentPage;

	/**
	 * Method selectPage
	 *
	 * @param string $name
	 * @return Base
	 *
	 * @since   1.4.4
	 */
	private function selectPage( $name ) {
		switch ( $name ) {
			case 'Cart':
				$page = new CartPage( $this );
				break;
			case 'Checkout':
				$page = new CheckoutPage( $this );
				break;
			case 'Product':
				$page = new ProductPage( $this );
				break;
			case 'Shop':
				$page = new ShopPage( $this );
				break;
			case 'Verified':
				$this->wait( 10 );
				$page = new VerifiedPage( $this );
				break;
			case 'Order Received':
				$this->wait( 20 );
				$page = new OrderReceivedPage( $this );
				break;
			case 'Pay Pal Log In':
				$this->wait( 10 );
				$page = new PayPalLogInPage( $this );
				break;
			case 'Pay Pal Review':
				$this->wait( 20 );
				$page = new PayPalReviewPage( $this );
				break;
			default:
				$page = null;
		}
		return $page;
	}

	/**
	 * Method getPageElement
	 *
	 * @param string $elementName
	 * @return string
	 *
	 * @since   1.4.4
	 */
	private function getPageElement( $elementName ) {
		//Takes the required element by it's name from required page
		return $this->currentPage->getElement( $elementName );
	}

	/**
	 * @Given I am on :page page
	 * @since 1.4.4
	 */
	public function iAmOnPage( $page ) {
		// Open the page and initialize required pageObject
		$this->currentPage = $this->selectPage( $page );
		$this->amOnPage( $this->currentPage->getURL() );
	}

	/**
	 * @When I click :object
	 * @since 1.4.4
	 */
	public function iClick( $object ) {
		 $this->waitForElementVisible( $this->getPageElement( $object ) );
		$this->waitForElementClickable( $this->getPageElement( $object ) );
		$this->click( $this->getPageElement( $object ) );
	}

	/**
	 * @When I am redirected to :page page
	 * @since 1.4.4
	 */
	public function iAmRedirectedToPage( $page ) {
		// Initialize required pageObject WITHOUT checking URL
		$this->currentPage = $this->selectPage( $page );
		// Check only specific keyword that page URL should contain
		$this->seeInCurrentUrl( $this->currentPage->getURL() );
	}

	/**
	 * @When I fill fields with :data
	 * @since 1.4.4
	 */
	public function iFillFieldsWith( $data ) {
		$this->fillFieldsWithData( $data, $this->currentPage );
	}

	/**
	 * @When I enter :fieldValue in field :fieldID
	 * @since 1.4.4
	 */
	public function iEnterInField( $fieldValue, $fieldID ) {
		$this->waitForElementVisible( $this->getPageElement( $fieldID ) );
		$this->fillField( $this->getPageElement( $fieldID ), $fieldValue );
	}

	/**
	 * @Then I see :text
	 * @since 1.4.4
	 */
	public function iSee( $text ) {
		 $this->see( $text );
	}

	/**
	 * @Given I prepare checkout
	 * @since 1.4.4
	 */
	public function iPrepareCheckout() {
		// Do choosing of product and adding it to the cart in PhpBrowser
		$productPage = new ProductPage( $this );
		$this->prepareCheckout( $productPage );
		//sync sessions between PhpBrowser and WebDriver
		$this->syncCookies();
	}

	/**
	 * @Given I login to Paypal
	 * @since 2.0.0
	 */
	public function iLoginToPaypal()
	{
		$this->currentPage->performPaypalLogin();
	}

}
