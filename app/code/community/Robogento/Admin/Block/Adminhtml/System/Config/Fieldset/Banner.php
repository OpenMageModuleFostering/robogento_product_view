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
 * Renderer for Robogento header
 *
 * @author Rian Orie
 * @license Copyright 2014 Robogento
 * @created 01-05-2014
 * @version 1.0
 */
class Robogento_Admin_Block_Adminhtml_System_Config_Fieldset_Banner extends Varien_Data_Form_Element_Fieldset
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
		return '
		<div class="robogento-notice" style="border: 1px solid #999; height: 110px; background: #4B4B4B;">
			<div style="float: left;height: 110px; margin-left: 5px;">
				<img src="'.Mage::getStoreConfig('roboadmin/urls/log').'?img=logo" alt="Robogento" style="margin: 30px 0 20px 20px;display: block;" />
				<p style="color: #fff;margin-left: 10px;">'.$this->__('Need help? Take a look at %s or get %s', '<a target="_blank" href="http://robogento.com">'.$this->__('our website').'</a>', '<a target="_blank" href="http://robogento.com/contact-us/">'.$this->__('in touch').'</a>').'</p>
			</div>
			<img src="'.Mage::getStoreConfig('roboadmin/urls/log').'?img=robot&info='.Mage::helper('roboadmin/remote')->getSystemInfo().'" alt="Robogento" style="float:left;margin-left: 50px;" height="110"  />
		</div>';
	}

	protected function _getHeaderHtml($element)
	{
		return $this->getId();
	}
}