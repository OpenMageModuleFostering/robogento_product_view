<?php
/**
 * Robogento
 *
 * NOTICE OF LICENSE
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited
 *
 * @category    Robogento
 * @package     Robogento_Admin
 * @copyright   Copyright (c) 2014 Robogento (http://robogento.com)
 */

/**
 * Observer to handle admin related features
 *
 * @author Rian Orie
 * @license Copyright 2014 Robogento
 * @created 01-05-2014
 * @version 1.0
 */
class Robogento_Admin_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * Initiate showing of the Robogento popup
	 *
	 * @param Varien_Event_Observer $event
	 */
	public function popup(Varien_Event_Observer $event)
	{
		/** @var Mage_Adminhtml_Controller_Action $controller */
		$controller = $event->getEvent()->getControllerAction();

		$notification = $controller->getLayout()->getBlock('notification_window');
		if ($notification && $notification->toHtml() == '') {

			$block = new Robogento_Admin_Block_Adminhtml_Popup();

			$body = $controller->getResponse()->getBody();
			$body = str_replace('</body>', $block->toHtml().'</body>', $body);
			$controller->getResponse()->setBody($body);

		}
	}
}