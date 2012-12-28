<?php

class Application_Model_DbTable_SleepCategoriesTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'Sleep_categories';

    protected $_dependentTables = array('Application_Model_DbTable_SleepTable');

}

