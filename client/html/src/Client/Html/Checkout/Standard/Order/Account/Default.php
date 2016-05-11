<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package Client
 * @subpackage Html
 */


/**
 * Default implementation of checkout order account HTML client
 *
 * @package Client
 * @subpackage Html
 */
class Client_Html_Checkout_Standard_Order_Account_Default
	extends Client_Html_Common_Client_Factory_Abstract
	implements Client_Html_Common_Client_Factory_Interface
{
	/** client/html/checkout/standard/order/account/default/subparts
	 * List of HTML sub-clients rendered within the checkout standard order account section
	 *
	 * The output of the frontend is composed of the code generated by the HTML
	 * clients. Each HTML client can consist of serveral (or none) sub-clients
	 * that are responsible for rendering certain sub-parts of the output. The
	 * sub-clients can contain HTML clients themselves and therefore a
	 * hierarchical tree of HTML clients is composed. Each HTML client creates
	 * the output that is placed inside the container of its parent.
	 *
	 * At first, always the HTML code generated by the parent is printed, then
	 * the HTML code of its sub-clients. The order of the HTML sub-clients
	 * determines the order of the output of these sub-clients inside the parent
	 * container. If the configured list of clients is
	 *
	 *  array( "subclient1", "subclient2" )
	 *
	 * you can easily change the order of the output by reordering the subparts:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1", "subclient2" )
	 *
	 * You can also remove one or more parts if they shouldn't be rendered:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1" )
	 *
	 * As the clients only generates structural HTML, the layout defined via CSS
	 * should support adding, removing or reordering content by a fluid like
	 * design.
	 *
	 * @param array List of sub-client names
	 * @since 2015.09
	 * @category Developer
	 */
	private $_subPartPath = 'client/html/checkout/standard/order/account/default/subparts';
	private $_subPartNames = array();


	/**
	 * Returns the HTML code for insertion into the body.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string HTML code
	 */
	public function getBody( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->_setViewParams( $this->getView(), $tags, $expire );

		$html = '';
		foreach( $this->_getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getBody( $uid, $tags, $expire );
		}
		$view->accountBody = $html;

		/** client/html/checkout/standard/order/account/default/template-body
		 * Relative path to the HTML body template of the checkout standard order account client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the layouts directory (usually in client/html/layouts).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page body
		 * @since 2015.09
		 * @category Developer
		 * @see client/html/checkout/standard/order/account/default/template-header
		 */
		$tplconf = 'client/html/checkout/standard/order/account/default/template-body';
		$default = 'checkout/standard/order-account-body-default.html';

		return $view->render( $this->_getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the HTML string for insertion into the header.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string|null String including HTML tags for the header on error
	 */
	public function getHeader( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->_setViewParams( $this->getView(), $tags, $expire );

		$html = '';
		foreach( $this->_getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getHeader( $uid, $tags, $expire );
		}
		$view->accountHeader = $html;

		/** client/html/checkout/standard/order/account/default/template-header
		 * Relative path to the HTML header template of the checkout standard order account client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the HTML code that is inserted into the HTML page header
		 * of the rendered page in the frontend. The configuration string is the
		 * path to the template file relative to the layouts directory (usually
		 * in client/html/layouts).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page head
		 * @since 2015.09
		 * @category Developer
		 * @see client/html/checkout/standard/order/account/default/template-body
		 */
		$tplconf = 'client/html/checkout/standard/order/account/default/template-header';
		$default = 'checkout/standard/order-account-header-default.html';

		return $view->render( $this->_getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return Client_Html_Interface Sub-client object
	 */
	public function getSubClient( $type, $name = null )
	{
		/** client/html/checkout/standard/order/account/decorators/excludes
		 * Excludes decorators added by the "common" option from the checkout standard order account html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "client/html/common/decorators/default" before they are wrapped
		 * around the html client.
		 *
		 *  client/html/checkout/standard/order/account/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("Client_Html_Common_Decorator_*") added via
		 * "client/html/common/decorators/default" to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2015.09
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/checkout/standard/order/account/decorators/global
		 * @see client/html/checkout/standard/order/account/decorators/local
		 */

		/** client/html/checkout/standard/order/account/decorators/global
		 * Adds a list of globally available decorators only to the checkout standard order account html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("Client_Html_Common_Decorator_*") around the html client.
		 *
		 *  client/html/checkout/standard/order/account/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "Client_Html_Common_Decorator_Decorator1" only to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2015.09
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/checkout/standard/order/account/decorators/excludes
		 * @see client/html/checkout/standard/order/account/decorators/local
		 */

		/** client/html/checkout/standard/order/account/decorators/local
		 * Adds a list of local decorators only to the checkout standard order account html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("Client_Html_Checkout_Decorator_*") around the html client.
		 *
		 *  client/html/checkout/standard/order/account/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "Client_Html_Checkout_Decorator_Decorator2" only to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2015.09
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/checkout/standard/order/account/decorators/excludes
		 * @see client/html/checkout/standard/order/account/decorators/global
		 */

		return $this->_createSubClient( 'checkout/standard/order/account/' . $type, $name );
	}


	/**
	 * Processes the input, e.g. provides the account form.
	 * A view must be available and this method doesn't generate any output
	 * besides setting view variables.
	 */
	public function process()
	{
		$view = $this->getView();
		$basket = $view->orderBasket;

		if( $basket->getCustomerId() == '' )
		{
			$email = '<unknown>';
			$context = $this->_getContext();

			try
			{
				$addr = $basket->getAddress( MShop_Order_Item_Base_Address_Abstract::TYPE_PAYMENT );
				$email = $addr->getEmail();

				$manager = MShop_Factory::createManager( $context, 'customer' );
				$search = $manager->createSearch();
				$search->setConditions( $search->compare( '==', 'customer.code', $email ) );
				$search->setSlice( 0, 1 );
				$result = $manager->searchItems( $search );

				if( empty( $result ) )
				{
					$orderBaseManager = MShop_Factory::createManager( $context, 'order/base' );

					$password = substr( md5( microtime( true ) . /*getpid() .*/ rand() ), -8 );
					$item = $this->_addCustomerData( $manager->createItem(), $addr, $addr->getEmail(), $password );
					$manager->saveItem( $item );

					$context->setUserId( $item->getId() );
					$basket->setCustomerId( $item->getId() );

					$orderBaseManager->saveItem( $basket, false );

					$this->_sendEmail( $addr, $addr->getEmail(), $password );
				}
			}
			catch( Exception $e )
			{
				$msg = sprintf( 'Unable to create an account for "%1$s": %2$s', $email, $e->getMessage() );
				$context->getLogger()->log( $msg, MW_Logger_Abstract::INFO );
			}
		}

		parent::process();
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of HTML client names
	 */
	protected function _getSubClientNames()
	{
		return $this->_getContext()->getConfig()->get( $this->_subPartPath, $this->_subPartNames );
	}


	/**
	 * Adds the customer and address data to the given customer item
	 *
	 * @param MShop_Customer_Item_Interface $customer Customer object
	 * @param MShop_Common_Item_Address_Interface $address Billing address object
	 * @return MShop_Customer_Item_Interface Customer object filled with data
	 */
	protected function _addCustomerData( MShop_Customer_Item_Interface $customer,
		MShop_Common_Item_Address_Interface $address, $code, $password )
	{
		$label = $address->getLastname();

		if( ( $part = $address->getFirstname() ) !== '' ) {
			$label = $part . ' ' . $label;
		}

		if( ( $part = $address->getCompany() ) !== '' ) {
			$label .= ' (' . $part . ')';
		}

		$customer->setPaymentAddress( $address );
		$customer->setCode( $code );
		$customer->setPassword( $password );
		$customer->setLabel( $label );
		$customer->setStatus( 1 );

		return $customer;
	}


	/**
	 * Sends the account creation e-mail to the e-mail address of the customer
	 *
	 * @param MShop_Common_Item_Address_Interface $address Payment address item of the customer
	 * @param string $code Customer login name
	 * @param string $password Customer clear text password
	 */
	protected function _sendEmail( MShop_Common_Item_Address_Interface $address, $code, $password )
	{
		$context = $this->_getContext();
		$client = Client_Html_Email_Account_Factory::createClient( $context, $this->_getTemplatePaths() );

		$view = $context->getView();
		$view->extAccountCode = $code;
		$view->extAccountPassword = $password;
		$view->extAddressItem = $address;

		$mailer = $context->getMail();
		$message = $mailer->createMessage();
		$helper = new MW_View_Helper_Mail_Default( $view, $message );
		$view->addHelper( 'mail', $helper );

		$client->setView( $view );
		$client->getHeader();
		$client->getBody();

		$mailer->send( $message );
	}
}