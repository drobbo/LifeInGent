<?php

class Application_Model_DbTable_SleepTable extends Zend_Db_Table_Abstract
{

    protected $_name = 'Sleep';

    protected $_dependentTables = array('Application_Model_DbTable_SleepImagesTable');
    
    protected $_referenceMap    = array(
        'sleepcategory' => array(
            'columns'           => array('fk_sleep_category'),
            'refTableClass'     => 'Application_Model_DbTable_SleepCategoriesTable',
            'refColumns'        => array('sleep_category_id')
        ),
    );
}

