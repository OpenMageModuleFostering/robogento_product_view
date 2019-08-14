<?php
/**
 * Robogento
 *
 * NOTICE OF LICENSE
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited
 *
 * @category    Robogento
 * @package     Robogento_ViewProductButton
 * @copyright   Copyright (c) 2014 Robogento (http://robogento.com)
 */

/**
 * Additional button for the product header to be able to quickly open a product
 *
 * @author Rian Orie
 * @license Copyright 2014 Robogento
 * @created 02-05-2014
 * @version 1.0
 */
class Robogento_ViewProductButton_Block_Product_Edit extends Mage_Adminhtml_Block_Catalog_Product_Edit
{

	/**
	 * Retrieve the back button and add our own product view button into it
	 *
	 * @return string
	 */
	public function getBackButtonHtml()
	{
		// Load the default back button
		$out = $this->getChildHtml('back_button');

		// If the module is enabled
		if (Mage::getStoreConfigFlag('roboviewproduct/general/enabled')) {

			// Initiate our own button
			$button = $this->getLayout()->createBlock('adminhtml/widget_button')
						                ->setLabel(Mage::helper('catalog')->__('View Product'))
						                ->setClass('disabled')
						                ->setDisabled(true);

			// If there's a product..
			if ($this->getProduct() != null) {

				// grab the path, preferably a fancy one
				$urlPath = $this->getProduct()->getProductUrl();
				if ($this->getProduct()->getUrlPath() != '') {
					$urlPath = Mage::getBaseUrl().$this->getProduct()->getUrlPath();
				}

				// Add the optional query argument
				$query = Mage::getStoreConfig('roboviewproduct/general/query');
				if (!empty($query)) {
					$query = '?'.str_replace(array('%random%', '%time%'), array(md5(time()), time()), ltrim($query, '?'));
				}

				// Add the onclick to it
				$button->setOnClick("window.open('".$urlPath.$query."','preview');");

				$errors = array();

				// If no website is selected
				if (count($this->getProduct()->getWebsiteIds()) == 0) {
					$errors[] = Mage::helper('catalog')->__('No website selected for the product.');
				}

				// If the visibility is too low
				if ($this->getProduct()->getVisibility() < 2) {
					$errors[] = Mage::helper('catalog')->__('Product visibility is set too low.');
				}

				// if the status is not enabled
				if ($this->getProduct()->getStatus() != 1) {
					$errors[] = Mage::helper('catalog')->__('The product status needs to be set to enabled.');
				}

				// If the product is part of a website, the visibility is set and the status
				// is set to enabled, remove the disabling elements
				if (count($errors) == 0) {
					$button->setDisabled(false)->setClass('');

				} else {
					$button->setTitle( implode(' ', $errors) );
				}
			}

			// Finally return the original button and the new one, together
			return $out.$button->toHtml();
		}

		return $out;
	}
}