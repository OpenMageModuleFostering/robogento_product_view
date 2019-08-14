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
 * Custom renderer for the admin configuration area
 *
 * @author Rian Orie
 * @license Copyright 2014 Robogento
 * @created 01-05-2014
 * @version 1.0
 */
class Robogento_Admin_Block_Adminhtml_System_Config_Form_Fieldset extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
	/**
	 * {@inheritdoc}
	 */
	public function render(Varien_Data_Form_Element_Abstract $element)
	{
		if (strpos($element->getId(), 'robogentomodules') !== false) {
			return $this->renderModules();
		} elseif (strpos($element->getId(), 'robogentobanner') !== false) {
			return $this->renderBanner();
		}

		$html = $this->_getHeaderHtml($element);

		foreach ($element->getSortedElements() as $field) {
			$html.= $field->toHtml();
		}

		$html .= $this->_getFooterHtml($element);

		return $html;
	}

	/**
	 * Custom renderer for Robogento Admin
	 *
	 * @return string
	 */
	public function renderBanner()
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

	/**
	 * Custom renderer for Robogento Admin
	 *
	 * @return string
	 */
	public function renderModules()
	{
		$remote = Mage::helper('roboadmin/remote');
		$url = Mage::getStoreConfig('roboadmin/urls/store').'?info='.$remote->getSystemInfo();

		return $remote->load($url);
	}
}