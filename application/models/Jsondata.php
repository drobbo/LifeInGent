<?php

class Application_Model_Jsondata extends Zend_Db_Table_Abstract
{
    public static function populateDatabase()
    {
        $Ziekenhuizen = file_get_contents('http://data.appsforghent.be/poi/ziekenhuizen.json');
        $dec_ziekenhuizen = json_decode($Ziekenhuizen, true);
        
        $names = array();
        $c=count($dec_ziekenhuizen['ziekenhuizen']);
        
        //$dbhost = 'localhost:8888';
        //$dbuser = 'root';
        //$dbpass = 'root';
          
        //$db = Zend_Db_Table::getDefaultAdapter();
        //$authAdapter = new Zend_Auth_Adapter_DbTable($db);
        //print_r('<pre>');
        //print_r($db['_config:protected'']);
        //$conn = mysql_connect($db.host, );
        //$conn = mysql_connect($dbhost, $dbuser, $dbpass);
       
        //if(! $conn )
        //{
        //    die('Could not connect: ' . mysql_error());
        //}
        
        //mysql_select_db('lifeingent');
        
        
        $truncateHospitals = mysql_query("TRUNCATE TABLE `Hospitals`");
        if(! $truncateHospitals )
        {
            die('Could not enter data: ' . mysql_error());
        }
        
        for ($i=0; $i < $c; $i++)
        {
            $item = array();
            
            $id = $i + 1;
            
            $name = $dec_ziekenhuizen['ziekenhuizen'][$i]['naam'];
            $item['name'] = $name;
            
            $address = $dec_ziekenhuizen['ziekenhuizen'][$i]['straat'] . ' ' . $dec_ziekenhuizen['ziekenhuizen'][$i]['nr'];
            $item['address'] = $address;
            
            $lat = $dec_ziekenhuizen['ziekenhuizen'][$i]['lat'];
            $item['lat'] = $lat;
            
            $long = $dec_ziekenhuizen['ziekenhuizen'][$i]['long'];
            $item['long'] = $long;
            
            array_push($names, $item);

            $sql = "INSERT INTO `lifeingent`.`Hospitals` (
                `hospital_id` ,
                `hospital_name` ,
                `hospital_address` ,
                `hospital_long` ,
                `hospital_lat`
                )
                VALUES (
                " . $id . " , '" . $name . "', '" . $address . "', '" . $long . "', '" . $lat . "'
                )";
   
            $retval = mysql_query( $sql, $conn );
            if(! $retval )
            {
                die('Could not enter data: ' . mysql_error());
            }
        }
        
        mysql_close($conn);
        
        print_r('<pre>');
        print_r($names);  
        
        print_r($dec_ziekenhuizen);
    }
}

