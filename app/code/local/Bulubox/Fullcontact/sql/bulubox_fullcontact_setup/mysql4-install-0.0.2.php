<?php
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = $this;
$installer->startSetup();
 
$table = $installer->getConnection()
    ->newTable($installer->getTable('bulubox_fullcontact/people'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'id')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array('nullable' => false), 'customer_id')
    ->addColumn('customer_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(), 'customer_name')
    ->addColumn('order_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, 0, array(), 'order_date')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(), 'order_id')
    ->addColumn('details', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(), 'details HTML');

$installer->getConnection()->createTable($table);
$installer->endSetup();