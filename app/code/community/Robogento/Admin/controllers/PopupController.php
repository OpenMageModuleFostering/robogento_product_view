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
 * Popup Controller that manages the popup related actions
 *
 * @author Rian Orie
 * @license Copyright 2014 Robogento
 * @created 01-05-2014
 * @version 1.0
 */
class Robogento_Admin_PopupController extends Mage_Core_Controller_Front_Action
{
	/**
	 * Forward the registration of an user to the Robogento system
	 *
	 */
	public function registerAction()
	{
		Mage::getConfig()->saveConfig('roboadmin/popup/registered', 1);
		Mage::getConfig()->reinit();
		Mage::app()->reinitStores();

		$helper = Mage::helper('roboadmin/remote');

		$info = $helper->getSystemInfo();
		$url = Mage::getStoreConfig('roboadmin/urls/register');
		$url .= 'info/'.$info.'/name/'.urlencode($this->getRequest()->getParam('name')).'/email/'.urlencode($this->getRequest()->getParam('email'));

		$helper->load($url);

		$this->getResponse()->setHeader('location', $this->_getRefererUrl().'roboadmin/done/');
	}

	/**
	 * Close the popup
	 */
	public function closeAction()
	{
		$this->getResponse()->setHeader('location', $this->_getRefererUrl().'roboadmin/close/');
	}

	/**
	 * Stop showing the popup without registering
	 *
	 */
	public function endAction()
	{
		Mage::getConfig()->saveConfig('roboadmin/popup/registered', 1);
		Mage::getConfig()->reinit();
		Mage::app()->reinitStores();

		$this->_redirectReferer();
	}
}