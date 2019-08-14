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
 * Feed class to import Robogento notifications
 *
 * @author Rian Orie
 * @license Copyright 2014 Robogento
 * @created 01-05-2014
 * @version 1.0
 */
class Robogento_Admin_Model_Feed extends Mage_AdminNotification_Model_Feed
{
	/**
	 * Grab the feed URL for Robogento
	 *
	 * @return string
	 */
	public function getFeedUrl()
	{
		return Mage::getStoreConfig('roboadmin/urls/notifications');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLastUpdate()
	{
		return Mage::app()->loadCache('roboadmin_notifications_lastcheck');
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLastUpdate()
	{
		Mage::app()->saveCache(time(), 'roboadmin_notifications_lastcheck');
		return $this;
	}
}