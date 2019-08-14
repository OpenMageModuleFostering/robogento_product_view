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
 * Helper for handling remote interactions with the Robogento system
 *
 * @author Rian Orie
 * @license Copyright 2014 Robogento
 * @created 01-05-2014
 * @version 1.0
 */
class Robogento_Admin_Helper_Remote extends Mage_Core_Helper_Abstract
{
	/**
	 * Load a remote url and parse its output. Method assumes the remote urls are Robogento URLs.
	 *
	 * @param string $path
	 *
	 * @return Zend_Http_Response
	 * @throws Zend_Http_Client_Exception
	 */
	public function load($path)
	{
		$client = new Zend_Http_Client($path, array('ssltransport' => true,
		                                            'adapter'   => 'Zend_Http_Client_Adapter_Curl',
		                                            'curloptions' => array(CURLOPT_FOLLOWLOCATION => true)));
		$request = $client->request();

		return $request->getBody();
	}

	/**
	 * Return the system info in an encoded version
	 *
	 * @return string
	 */
	public function getSystemInfo()
	{
		$info = array('modules' => array(), 'magento' => array());
		$edition = 'Community';

		$modules = Mage::getConfig()->getNode('modules')->children();
		foreach($modules as $k => $m) {
			if (strpos($k, 'Robogento') !== false) {
				$info['modules'][] = array('module' => $k, 'version' => (string)$m->version);

			} elseif ($k == 'Enterprise_Enterprise') {
				$edition = 'Enterprise';
			}
		}


		if (method_exists('Mage', 'getEdition')) {
			$edition = Mage::getEdition();
		}

		$info['magento'] = array('site' => Mage::getBaseUrl(), 'edition' => $edition, 'version' => Mage::getVersion());

		return base64_encode(json_encode($info));
	}
}