<?php
class Bulubox_Fullcontact_Model_Mysql4_People extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {   
        $this->_init('bulubox_fullcontact/people', 'id');
    }   
}