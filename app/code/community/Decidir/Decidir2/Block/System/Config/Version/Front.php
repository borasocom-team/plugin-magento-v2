<?php
class Decidir_Decidir2_Block_System_Config_Version_Front extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected $_values = null;
    
    protected function _construct()
    {
        $this->setTemplate('decidir2/system/config/version.phtml');
        return parent::_construct();
    }
    
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setNamePrefix($element->getName())
            ->setHtmlId($element->getHtmlId());
        return $this->_toHtml();
    }
    
    public function getVersion() {
        $ver = Mage::getConfig()->getModuleConfig("Decidir_Decidir2")->version;
        return $ver[0];
    }
}