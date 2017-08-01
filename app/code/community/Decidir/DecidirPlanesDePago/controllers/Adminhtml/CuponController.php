<?php

class Decidir_DecidirPlanesDePago_Adminhtml_CuponController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu("decidirplanesv1/cupon")->_addBreadcrumb(Mage::helper("adminhtml")->__("Cupon  Manager"), Mage::helper("adminhtml")->__("Cupon Manager"));
        return $this;
    }

    public function indexAction() {
        $this->_title($this->__("Decidirplanesv1"));
        $this->_title($this->__("Manager Cupon"));

        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction() {
        $this->_title($this->__("Decidirplanesv1"));
        $this->_title($this->__("Cupon"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("decidirplanesv1/cupon")->load($id);
        if ($model->getId()) {
            Mage::register("cupon_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("decidirplanesv1/cupon");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Cupon Manager"), Mage::helper("adminhtml")->__("Cupon Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Cupon Description"), Mage::helper("adminhtml")->__("Cupon Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_cupon_edit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_cupon_edit_tabs"));
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("decidirplanesv1")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }

    public function newAction() {

        $this->_title($this->__("Decidirplanesv1"));
        $this->_title($this->__("Cupon"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("decidirplanesv1/cupon")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("cupon_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("decidirplanesv1/cupon");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Cupon Manager"), Mage::helper("adminhtml")->__("Cupon Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Cupon Description"), Mage::helper("adminhtml")->__("Cupon Description"));


        $this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_cupon_edit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_cupon_edit_tabs"));

        $this->renderLayout();
    }

    public function saveAction() {

        $post_data = $this->getRequest()->getPost();

        if ($post_data) {

            try {


                //$post_data['store_id'] = implode(',', $post_data['store_id']);
                foreach ($post_data['store_id'] as $value) {
                    $post_data['store_id']=$value;
                    $model = Mage::getModel("decidirplanesv1/cupon")
                            ->addData($post_data)
                            ->setId($this->getRequest()->getParam("id"))
                            ->save();
                }
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Cupon was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setCuponData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::log($e->getMessage());
                Mage::getSingleton("adminhtml/session")->addError("Error al guardar, revise los datos e intente nuevamente");
                Mage::getSingleton("adminhtml/session")->setCuponData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }

        $this->_redirect("*/*/");
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("decidirplanesv1/cupon");
                $model->setId($this->getRequest()->getParam("id"))->delete();
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
                $this->_redirect("*/*/");
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
        $this->_redirect("*/*/");
    }

    public function massRemoveAction() {
        try {
            $ids = $this->getRequest()->getPost('cupon_ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("decidirplanesv1/cupon");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction() {
        $fileName = 'cupon.csv';
        $grid = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_cupon_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction() {
        $fileName = 'cupon.xml';
        $grid = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_cupon_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}
