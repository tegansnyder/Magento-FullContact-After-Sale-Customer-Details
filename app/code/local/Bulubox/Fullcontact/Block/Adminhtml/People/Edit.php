<?php
class Bulubox_Fullcontact_Block_Adminhtml_People_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /** 
     * Init class
     */
    public function __construct()
    {   
        $this->_blockGroup = 'bulubox_fullcontact';
        $this->_controller = 'adminhtml_people';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Save'));
        $this->_updateButton('delete', 'label', $this->__('Delete'));
    }   
     
    /** 
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {   
        if (Mage::registry('bulubox_fullcontact')->getId()) {
            return $this->__('Edit');
        }   
    }   
}