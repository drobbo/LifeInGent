<?php

class Application_Model_DbTable_SleepImagesTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'Sleep_images';

    protected $_referenceMap    = array(
        'Sleep' => array(
            'columns'           => array('fk_sleep'),
            'refTableClass'     => 'Application_Model_DbTable_SleepTable',
            'refColumns'        => array('sleep_id')
        ),
    );
}

