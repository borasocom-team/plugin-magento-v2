<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "decidirplanesv1";
				$this->_controller = "adminhtml_interes";
				$this->_updateButton("save", "label", Mage::helper("decidirplanesv1")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("decidirplanesv1")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("decidirplanesv1")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("interes_data") && Mage::registry("interes_data")->getId() ){

				    return Mage::helper("decidirplanesv1")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("interes_data")->getId()));

				}
				else{

				     return Mage::helper("decidirplanesv1")->__("Crear nuevo Interes de Cuotas");

				}
		}
}
