<?php
class Bulubox_Fullcontact_Adminhtml_PeopleController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {   
        $this->_initAction()->renderLayout();
    }   
     
    public function newAction()
    {   
        $this->_forward('edit');
    }   
     
    public function editAction()
    {   
        $this->_initAction();
     
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('bulubox_fullcontact/people');
     
        if ($id) {

            $model->load($id);
     
            if (!$model->getId()) {
            
                Mage::getSingleton('adminhtml/session')->addError($this->__('No record found'));
                
                $this->_redirect('*/*/');
     
                return;
            }   
        }   
     
        $this->_title($model->getId() ? $model->getName() : $this->__('New'));
     
        $data = Mage::getSingleton('adminhtml/session')->getPeopleData(true);
        
        if (!empty($data)) {
            $model->setData($data);
        }   
     
        Mage::register('bulubox_fullcontact', $model);
     
        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit') : $this->__('New'), $id ? $this->__('Edit') : $this->__('New'))
            ->_addContent($this->getLayout()->createBlock('bulubox_fullcontact/adminhtml_people_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }
     
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {

            $model = Mage::getSingleton('bulubox_fullcontact/people');

            try {
            
                $model->setData($postData);
                
                $model->save();
 
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Saved sucessfully'));
                $this->_redirect('*/*/');
 
                return;
            }   
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Error saving'));
            }
 
            Mage::getSingleton('adminhtml/session')->setPeopleData($postData);
            $this->_redirectReferer();
        }
    }
    public function exportCsvAction()
    {
        $fileName   = 'people.csv';
        $grid       = $this->getLayout()->createBlock('bulubox_fullcontact/adminhtml_people_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getCsv());
    }

    public function exportExcelAction()
    {
        $fileName   = 'people.xls';
        $grid       = $this->getLayout()->createBlock('bulubox_fullcontact/adminhtml_people_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
 
    public function messageAction()
    {
        $data = Mage::getModel('bulubox_fullcontact/people')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }
    
    public function deleteAction() {
    
		if( $this->getRequest()->getParam('id') > 0 ) {
		
			try {
			
				$model = Mage::getModel('bulubox_fullcontact/people');
				$model->setId($this->getRequest()->getParam('id'))->delete();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				
				$this->_redirect('*/*/');
				
			} catch (Exception $e) {
			
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				
			}
		}
		
		$this->_redirect('*/*/');
	}
	
	
	public function massDeleteAction() {
	
	    $ids = $this->getRequest()->getParam('id');
	    
	    if(!is_array($ids)) {
	    
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
	  
	    } else {
	        try {
	        
	            foreach ($ids as $id) {
	                $model = Mage::getModel('bulubox_fullcontact/people')->load($id);
	                $model->delete();
	            }
	            
	            Mage::getSingleton('adminhtml/session')->addSuccess(
	                Mage::helper('adminhtml')->__(
	                    'Total of %d record(s) were successfully deleted', count($ids)
	                )
	            );
	            
	        } catch (Exception $e) {
	            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	        }
	    }
	    
	    $this->_redirect('*/*/index');
	}
 

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sales/bulubox_fullcontact_people')
            ->_title($this->__('Customers'))->_title($this->__('Full Contact'))
            ->_addBreadcrumb($this->__('Customers'), $this->__('Customers'))
            ->_addBreadcrumb($this->__('Full Contact'), $this->__('Full Contact'));
         
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
        
        	$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        	
        }
        
         
        return $this;
    }
     
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/bulubox_fullcontact_people');
    }
    
}
