<?php

class Application_Model_DbTable_PoiCategoriesTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'Poi_categories';
    
    protected $_dependentTables = array('Application_Model_DbTable_PoiTable');

}

