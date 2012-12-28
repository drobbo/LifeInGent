<?php

class Application_Model_DbTable_PoiImagesTable extends Zend_Db_Table_Abstract
{

    protected $_name = 'PoiImages';
    
    protected $_referenceMap    = array(
        'Poi' => array(
            'columns'           => array('fk_poi'),
            'refTableClass'     => 'Application_Model_DbTable_PoiTable',
            'refColumns'        => array('poi_id')
        ),
    );
}

