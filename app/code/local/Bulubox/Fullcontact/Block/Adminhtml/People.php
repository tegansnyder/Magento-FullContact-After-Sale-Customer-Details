<?php
class Bulubox_Fullcontact_Block_Adminhtml_People extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'bulubox_fullcontact';
        $this->_controller = 'adminhtml_people';
        $this->_headerText = $this->__('Full Contact');
        
        parent::__construct();
    }
}