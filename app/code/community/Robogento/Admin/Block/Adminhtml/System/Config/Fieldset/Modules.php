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
 * Renderer for nested shop in the Magento admin
 *
 * @author Rian Orie
 * @license Copyright 2014 Robogento
 * @created 01-05-2014
 * @version 1.0
 */
class Robogento_Admin_Block_Adminhtml_System_Config_Fieldset_Modules extends Varien_Data_Form_Element_Fieldset
    implements Varien_Data_Form_Element_Renderer_Interface
{
	/**
	 * Custom renderer for Robogento Admin
	 *
	 * @param Varien_Data_Form_Element_Abstract $element
	 *
	 * @return string
	 */
	public function render(Varien_Data_Form_Element_Abstract $element)
	{
		$remote = Mage::helper('roboadmin/remote');
		$url = Mage::getStoreConfig('roboadmin/urls/store').'?info='.$remote->getSystemInfo();

		$data = $remote->load($url);

		return $data;
	}
}