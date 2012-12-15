<?php
class Bulubox_Fullcontact_Block_Adminhtml_People_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        $this->setDefaultSort('id');
        $this->setId('bulubox_fullcontact_people_grid');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        
    }
     
    protected function _getCollectionClass()
    {
        return 'bulubox_fullcontact/people_collection';
    }
     
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
     protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('fullcontact_people');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => $this->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => $this->__('Are you sure?')
        ));

        return $this;
    }

    protected function _prepareColumns()
    {
       
        $this->addExportType('*/*/exportCsv', Mage::helper('bulubox_fullcontact')->__('CSV'));
		$this->addExportType('*/*/exportExcel',Mage::helper('bulubox_fullcontact')->__('Excel XML'));
	
		$this->addColumn('customer_id',
            array(
                'header'=> $this->__('Customer ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'id'
            )
        );
        
        $this->addColumn('customer_name',
            array(
                'header'=> $this->__('customer_name'),
                'index' => 'customer_name'
            )
        );
        
        $this->addColumn('order_date',
            array(
                'header'	=> $this->__('order_date'),
                'index' 	=> 'order_date',
        		'type'		=>'datetime'
	    	)
        );

        $this->addColumn('action',
            array(
                'header'    =>  $this->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => $this->__('Delete'),
                        'url'       => array('base'=> '*/*/delete'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        )); 
        
        return parent::_prepareColumns();
        
    }
     
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
}
