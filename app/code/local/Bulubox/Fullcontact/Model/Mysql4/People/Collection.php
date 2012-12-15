<?php
class Bulubox_Fullcontact_Model_Mysql4_People_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {   
        $this->_init('bulubox_fullcontact/people');
    }
    
    public function addFilterByOrderId($order_id) {
        $this->addFieldToFilter('order_id', $order_id);
        return $this;
    }
}