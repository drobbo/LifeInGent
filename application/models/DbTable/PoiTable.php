<?php

class Application_Model_DbTable_PoiTable extends Zend_Db_Table_Abstract
{

    protected $_name = 'Poi';
    
    protected $_dependentTables = array('Application_Model_DbTable_PoiImagesTable');
    
    protected $_referenceMap    = array(
        'poicategory' => array(
            'columns'           => array('fk_poi_category'),
            'refTableClass'     => 'Application_Model_DbTable_PoiCategoriesTable',
            'refColumns'        => array('poi_category_id')
        ),
    );
}

