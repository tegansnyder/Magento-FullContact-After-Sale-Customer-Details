<?php
class Bulubox_Fullcontact_Block_Adminhtml_People_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {   
        parent::__construct();
     
        $this->setId('bulubox_fullcontact_people_form');
        $this->setTitle($this->__('Peoplecription Information'));
    }   
     

    protected function _prepareForm()
    {   
        $model = Mage::registry('bulubox_fullcontact');
            
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        )); 
     
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Data collected via Full Contact API'),
            'class'     => 'fieldset-wide',
        )); 
     	
        if ($model->getId()) {
        
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
            
            $fieldset->addField('customer_id', 'hidden', array(
                'name' => 'customer_id',
            )); 
            
            $fieldset->addField('order_date', 'hidden', array(
                'name' => 'order_date',
            )); 
            
        }
        
        $fieldset->addField('customer_name', 'text', array(
            'name'      => 'customer_name',
            'label'     => Mage::helper('checkout')->__('Customer Name'),
            'title'     => Mage::helper('checkout')->__('Customer Name'),
            'required'  => true,
        ));
        
     	$fieldset->addField('order_id', 'text', array(
     	    'name'      => 'order_id',
     	    'label'     => Mage::helper('checkout')->__('Order ID'),
     	    'title'     => Mage::helper('checkout')->__('Order ID'),
     	    'required'  => false,
     	));
     	
     	$fieldset->addField('details', 'editor', array( 
	     	'name' => 'details',
	     	'label' => Mage::helper('checkout')->__('Details'), 
	     	'title' => Mage::helper('checkout')->__('Details'),
	     	'style' => 'width:700px; height:500px;',
	     	'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
	     	'wysiwyg' => true,
	     	'required' => true,
     	));
        
        
        $form->setValues($model->getData());
        
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }   
}