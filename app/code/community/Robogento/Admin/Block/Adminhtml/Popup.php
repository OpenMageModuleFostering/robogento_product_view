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
 * Popup block that will generate the actual popup as displayed in the admin
 *
 * @author Rian Orie
 * @license Copyright 2014 Robogento
 * @created 01-05-2014
 * @version 1.0
 */
class Robogento_Admin_Block_Adminhtml_Popup extends Mage_Core_Block_Template
{
	/**
	 * Class constructor, defines all the bases for the popupp
	 */
	public function __construct()
	{
		// This is clunky as hell, but the controller refuses to update the admin/session
		// properly
		if (Mage::app()->getRequest()->getParam('roboadmin', null) == 'close') {
			Mage::getSingleton('admin/session')->setRobogentoPopupShown(true);

		}

		if ( Mage::getSingleton('admin/session')->isLoggedIn()
		    && ! Mage::getStoreConfigFlag('roboadmin/popup/registered', 0)
		    && Mage::getSingleton('admin/session')->getRobogentoPopupShown() !== true) {

			$this->setTemplate('notification/window.phtml');

			$html = '</p>
					<form action="'.Mage::getUrl('roboadmin/popup/register').'" id="robogentoregister" method="post"><p>
					<input type="text" name="name" class="required-entry input-text" style="float:left; margin-right: 5px;" value="'.Mage::getSingleton('admin/session')->getUser()->getName().'" />
	                <input type="text" name="email" class="required-entry validate-email input-text" style="float:left; margin-right: 5px;" value="'.Mage::getSingleton('admin/session')->getUser()->getEmail().'" />
	                <button type="submit" id="register-robogento" style="float: left; padding-top: 1px;" class="form-button">
	                    <span>'.$this->__('Ok!').'</span>
                    </button>
	                </p></form>
	                <script type="text/javascript">
	                var roboForm = new varienForm(\'robogentoregister\');
	                </script>
	                <p>
	                ';

			$msg = Mage::getStoreConfig('roboadmin/popup/message');
			if (empty($msg)) {
				$msg = 'Click OK to register your e-mail and receive FREE support on your FREE module from Robogento!';
			}

			$this->setHeaderText( $this->__('Robogento Registration') );
			$this->setCloseText($this->__('Close') );
			$this->setSeverityText('');
			$this->setSeverityIconsUrl('https://robogento.com/skin/frontend/robomanager/robot.png');
			$this->setNoticeMessageText($this->__($msg).$html );
			$this->setNoticeMessageUrl('javascript:stopRobogentoPopup();');
			$this->setReadDetailsText($this->__('no thanks and don\'t show this popup again') );
		}
	}

	/**
	 * Can the popup be shown
	 *
	 * @return bool
	 */
	public function canShow()
	{
		return true;
	}

	/**
	 * Generate HTML output for the block
	 *
	 * @return string
	 */
	public function _toHtml()
	{
		if (Mage::getSingleton('admin/session')->isLoggedIn()) {
			return parent::_toHtml() . $this->getScript();
		}

		return parent::_toHtml();
	}

	/**
	 * Generate a piece of javascript that we use to adjust the popup
	 *
	 * @return string
	 */
	public function getScript()
	{
		return '<script type="text/javascript">
		var icon = $$("#message-popup-window .message-icon");
		if (icon && icon.length > 0) {
			icon[0].style.backgroundSize = "auto 100%";
		}

		el = $$("#message-popup-window .message-popup-head a");
		if (el && el.length > 0) {
			el = el[0];
			el.writeAttribute("onclick", "");
			el.href = \''.Mage::getUrl('roboadmin/popup/close').'\';
			el.target = "_self";
		}

        function stopRobogentoPopup() {
            window.location = \''.Mage::getUrl('roboadmin/popup/end').'\';
		}
		</script>';
	}
}