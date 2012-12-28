<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LifeInGentService
 *
 */
class Ahs_LifeInGentService {
    protected $db;
    protected $hospitals;
    protected $primaryschools;
    protected $youthorganisations;
    protected $poi;
    protected $images;
    protected $poicategories;
    protected $sleep;
    protected $sleepcategories;
    protected $sleepimages;
    
    function __construct() {
        $options = array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'root',
            'dbname' => 'lifeingent'
        );
        
        $this->db = Zend_db::factory('PDO_MYSQL', $options);
        Zend_Db_Table_Abstract::setDefaultAdapter($this->db);
    }
    
    public function getAdminData($id){
        
        $mapper = new Backoffice_Model_AdminMapper();
        $rows = $mapper->read($id);
        
        
        return $rows;
    }
    
    public function updateAdminData(Backoffice_Model_Admin $admin, $id = null){
        $mapper = new Backoffice_Model_AdminMapper();
        $mapper->save($admin,$id);
        
        return true;
    }
    
    public function getAllHospitals(){
        $this->hospitals = new Application_Model_DbTable_HospitalsTable();
        
        $select = $this->hospitals->select();
        $rows = $this->hospitals->fetchAll()->toArray();
        
        return $rows;
    }
    
    public function updateHospitals() 
    {
        try {
            $this->hospitals = new Application_Model_DbTable_HospitalsTable();
            $content = @file_get_contents('http://data.appsforghent.be/poi/ziekenhuizen.json');
            if($content === false) {
                throw new Zend_Exception('Wrong URL for getting hospitals.');
            }
            $ziekenhuizen = json_decode($content,true);

            $tName = $ziekenhuizen['ziekenhuizen']; 
            $c=count($tName);

            $first = 'naam';
            $second = 'straat';
            $third = 'nr';
            $fourth = 'lat';
            $fifth = 'long';

            $checkname = $tName[0][$first];
            $checkaddress = $tName[0][$second] . ' ' . $tName[0][$third];
            $checklat = $tName[0][$fourth];
            $checklong = $tName[0][$fifth];

            if($checkname!= "" && $checkaddress!= "" && $checklat!= "" && $checklong!= ""){
                $this->hospitals->delete('1');
            } else {
                throw new Zend_Exception('Error getting data online.');
            }

            for ($i=0; $i < $c; $i++)
            {
                $id = $i + 1;
                $name = $tName[$i][$first];
                $address = $tName[$i][$second] . ' ' . $tName[$i][$third];
                $lat = $tName[$i][$fourth];
                $long = $tName[$i][$fifth];

                $params = array(
                    'hospital_id' => $id,
                    'hospital_name' => $name,
                    'hospital_address' => $address,
                    'hospital_long' => $long,
                    'hospital_lat' => $lat
                );

                if($this->hospitals->insert($params)) {
                    
                } else {
                    return false;
                }   
            } return false;
        } 
        catch (Zend_Exception $exp) {
            echo 'Monkeys are trying to fix the errror in hospitals table. Error: ' . $exp->getMessage();
            return false;
        } 
    }
    
    public function updatePrimarySchools() 
    {
        try {
            $this->primaryschools = new Application_Model_DbTable_PrimaryschoolTable();

            $content = @file_get_contents('http://data.appsforghent.be/poi/basisscholen.json');
            if($content === false) {
                throw new Zend_Exception('Wrong URL.');
            } 
            $primarys = json_decode($content, true);

            
            $tName = $primarys['basisscholen']; 
            $c=count($tName);

            $first = 'roepnaam';
            $second = 'straat';
            $third = 'aanbod';
            $fourth = 'long';
            $fifth = 'lat';

            $checkname = $tName[0][$first];
            $checkaddress = $tName[0][$second];
            $checkoffer = $tName[0][$third];
            $checklat = $tName[0][$fourth];
            $checklong = $tName[0][$fifth];

            if($checkname!= "" && $checkaddress!= "" && $checkoffer!= "" && $checklat!= "" && $checklong!= ""){
                $this->primaryschools->delete('1');
            } else {
                throw new Zend_Exception('Error getting data online.');
            }

            for ($i=0; $i < $c; $i++)
            {
                $id = $i + 1;
                $name = $tName[$i][$first];
                $address = $tName[$i][$second];
                $offer = $tName[$i][$third];
                $long = $tName[$i][$fourth];
                $lat = $tName[$i][$fifth];

                $params = array(
                    'primary_school_id' => $id,
                    'primary_school_name' => $name,
                    'primary_school_address' => $address,
                    'primary_school_offer' => $offer,
                    'primary_school_long' => $long,
                    'primary_school_lat' => $lat,
                );

                if($this->primaryschools->insert($params)) {
                    
                } else {
                    return false;
                } 
            } return false;
        }
        catch (Zend_Exception $exp) {
            echo 'You broke the site! Good job... The error is in primary schools table. Error: ' . $exp->getMessage();
            return false;
        } 
    }
    
    public function updateYouthOrganisations() 
    {
        try{
            $this->youthorganisations = new Application_Model_DbTable_YouthorganisationTable();
            
            $content = @file_get_contents('http://data.appsforghent.be/poi/jeugdwerk.json');
            if($content === false) {
                throw new Zend_Exception('Wrong URL.');
            } 
            $youthorganisations = json_decode($content, true);
            
            $tName = $youthorganisations['jeugdwerk'];
            $c=count($tName);

            $first = 'organisati';
            $second = 'straat';
            $third = 'huisnr';
            $fourth = 'long';
            $fifth = 'lat';

            $checkname = $tName[0][$first];
            $checkaddress = $tName[0][$second] . ' ' . $tName[0][$third];
            $checklat = $tName[0][$fourth];
            $checklong = $tName[0][$fifth];
            if($checkname!= "" && $checkaddress!= "" && $checklat!= "" && $checklong!= ""){
                $this->youthorganisations->delete('1');
            } else {
                throw new Zend_Exception('Error getting data online.');
            }

            for ($i=0; $i < $c; $i++)
            {
                $id = $i + 1;
                $name = $tName[$i][$first];
                if($tName[$i][$third] == "z/n") {
                    $address = $tName[$i][$second];
                } else {
                    $address = $tName[$i][$second] . ' ' . $tName[$i][$third];
                }
                $long = $tName[$i][$fourth];
                $lat = $tName[$i][$fifth];

                $params = array(
                    'youth_organisation_id' => $id,
                    'youth_organisation_name' => $name,
                    'youth_organisation_address' => $address,
                    'youth_organisation_long' => $long,
                    'youth_organisation_lat' => $lat,
                );
                
                if($this->youthorganisations->insert($params)) {
                    
                } else {
                    return false;
                }
            } return false;
        }
        catch (Zend_Exception $exp) {
            echo "You are good in breaking stuff aren't you. The error is in Youth organisations table: " . $exp->getMessage();
            return false;
        } 
    }
    
    public function getPOI(){
        
        $this->poi = new Application_Model_DbTable_PoiTable();
        $select = $this->poi->select();
        $row = $this->poi->fetchAll($select);
        $arr = $row->toArray();
        for ($i = 0;$i<count($row);$i++){
            $images = $row[$i]->findDependentRowSet("Application_Model_DbTable_PoiImagesTable")->toArray();
            $arr[$i]["category"] = $row[$i]->findParentRow("Application_Model_DbTable_PoiCategoriesTable")["poi_category_name"];
            $arr[$i]["images"] = $images;
                
        }
        return $arr;
    }
    
    
    public function updatePOI() 
    {
        try {
            $this->poi = new Application_Model_DbTable_PoiTable();
            $this->images = new Application_Model_DbTable_PoiImagesTable();
            $this->poicategories = new Application_Model_DbTable_PoiCategoriesTable();

            $content = @file_get_contents('http://data.appsforghent.be/toerisme/infonl.json');
            if($content === false) {
                throw new Zend_Exception('Wrong URL.');
            } 
            $pois = json_decode($content, true);
            
            $categorysPOI = $pois['infonl']['nl']['categories'][1]['items'];
            $c = count($pois['infonl']['nl']['categories'][1]['items']);

            $checkname = $categorysPOI[0]['items'][0]['title'];
            $checkdescription = $categorysPOI[0]['items'][0]['info'];
            $checkrating = $categorysPOI[0]['items'][0]['rating'];

            if($checkname!= "" && $checkdescription!= "" && $checkrating!= "") {
                $this->images->delete('1');
                $this->poi->delete('1');
                $this->poicategories->delete('1');
            } else {
                throw new Zend_Exception('Error getting data online.');
            }

            $counter = 1;
            $counterImages = 1;

            for ($i=0; $i < $c; $i++)
            {
                $ItemsInCategory = count($categorysPOI[$i]['items']);
                $category = $i + 1;
                $categoryName = $pois['infonl']['nl']['categories'][1]['items'][$i]['title'];
                $paramsPoiCategories = array(
                    'poi_category_id' => $category,
                    'poi_category_name' => $categoryName,
                );
                
                if($this->poicategories->insert($paramsPoiCategories)) {
                    
                } else {
                    return false;
                }

                for ($b=0; $b < $ItemsInCategory; $b++)
                {
                    $POIid = $counter;
                    $name = $categorysPOI[$i]['items'][$b]['title'];
                    $description = $categorysPOI[$i]['items'][$b]['info'];
                    $rating = $categorysPOI[$i]['items'][$b]['rating'];

                    $telephone = $categorysPOI[$i]['items'][$b]['telephone'];
                    if($telephone == "") {
                        $telephone = "/";
                    }

                    $lat = $categorysPOI[$i]['items'][$b]['coordinates']['GPS'][0];
                    if($lat == "") {
                        $lat = "51.053468";
                    }

                    $long = $categorysPOI[$i]['items'][$b]['coordinates']['GPS'][1];
                    if($long == "") {
                        $long = "3.73038";
                    }

                    $address = $categorysPOI[$i]['items'][$b]['address']['street'] . ' ' . $categorysPOI[$i]['items'][$b]['address']['nr'];
                    if($address == " ") {
                        $address = 'Gent';
                    }

                    $brochure = $categorysPOI[$i]['items'][$b]['brochure'];
                    if($brochure == "") {
                        $brochure = 'none';
                    }

                    $paramsPOI = array(
                        'poi_id' => $POIid,
                        'fk_poi_category' => $category,
                        'poi_name' => $name,
                        'poi_description' => $description,
                        'poi_rating' => $rating,
                        'poi_telephone' => $telephone,
                        'poi_lat' => $lat,
                        'poi_long' => $long,
                        'poi_address' => $address,
                        'poi_brochure' => $brochure,
                    );

                    if($this->poi->insert($paramsPOI)) {
                    
                    } else {
                        return false;
                    }

                    for ($x=0; $x < 5; $x++) {
                        if($categorysPOI[$i]['items'][$b]['images'][$x]['url'] != "") {
                            $imageUrl = $categorysPOI[$i]['items'][$b]['images'][$x]['url'];
                            $imageDescription = $categorysPOI[$i]['items'][$b]['images'][$x]['description'];
                            $paramsImages = array(
                                'image_id' => $counterImages,
                                'image_url' => $imageUrl,
                                'image_description' => $imageDescription,
                                'fk_poi' => $POIid,
                            );
                            
                            if($this->images->insert($paramsImages)) {
                    
                            } else {
                                return false;
                            }
                            $counterImages++;
                        }
                    }
                    $counter++;
                }
            } return false;
        }
        catch (Zend_Exception $exp) {
            echo 'A fat guy just fell on the internets... Stand by... The error is in Points of interestzzzz table: ' . $exp->getMessage();
            return false;
        } 
    }
    
    public function updateSleep() 
    {
        try {
            $this->sleepcategories = new Application_Model_DbTable_SleepCategoriesTable();
            $this->sleep = new Application_Model_DbTable_SleepTable();
            $this->sleepimages = new Application_Model_DbTable_SleepImagesTable();

            $content = @file_get_contents('http://data.appsforghent.be/toerisme/infonl.json');
            if($content === false) {
                throw new Zend_Exception('Wrong URL.');
            } 
            $sleep = json_decode($content, true);

            $checksleepName = $sleep['infonl']['nl']['categories'][3]['items'][0]['items'][0]['title'];
            $checksleepDescription = $sleep['infonl']['nl']['categories'][3]['items'][0]['items'][0]['info'];
            $checksleepTelephone = $sleep['infonl']['nl']['categories'][3]['items'][0]['items'][0]['telephone'];
            $checksleepAddress = $sleep['infonl']['nl']['categories'][3]['items'][0]['items'][0]['address']['street'] . ' ' . $sleep['infonl']['nl']['categories'][3]['items'][0]['items'][0]['address']['nr'];

            if($checksleepName!= "" && $checksleepDescription!= "" && $checksleepTelephone!= "" && $checksleepAddress!= "") {
                $this->sleepcategories->delete('1');
                $this->sleep->delete('1');
                $this->sleepimages->delete('1');
            } else {
                throw new Zend_Exception('Error getting data online.');
            }
            
            $counterSleepItems = 1;
            $counterImages = 1;

            for ($i=0; $i < 9; $i++) 
            {
                $categoryName = $sleep['infonl']['nl']['categories'][3]['items'][$i]['title'];

                $paramsSleepCategories = array(
                    'sleep_category_id' => $i + 1,
                    'sleep_category_name' => $categoryName,
                );

                if($this->sleepcategories->insert($paramsSleepCategories)) {
                                
                } else {
                    return false;
                }

                $countCategoryItems = count($sleep['infonl']['nl']['categories'][3]['items'][$i]['items']);

                for ($d=0; $d < $countCategoryItems; $d++) {
                    $sleepName = $sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['title'];
                    $sleepDescription = $sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['info'];
                    $sleepTelephone = $sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['telephone'];
                    $sleepAddress = $sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['address']['street'] . ' ' . $sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['address']['nr'];
                    $sleepLat = $sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['coordinates']['GPS'][0];
                    $sleepLong = $sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['coordinates']['GPS'][1];
                    if($sleepLat == "") {
                        $sleepLat = "51.053468";
                    }

                    if($sleepLong == "") {
                        $sleepLong = "3.73038";
                    }

                    $paramsSleep = array(
                        'sleep_id' => $counterSleepItems,
                        'fk_sleep_category' => $i + 1,
                        'sleep_name' => $sleepName,
                        'sleep_description' => $sleepDescription,
                        'sleep_telephone' => $sleepTelephone,
                        'sleep_address' => $sleepAddress,
                        'sleep_lat' => $sleepLat,
                        'sleep_long' => $sleepLong,
                    );

                    if($this->sleep->insert($paramsSleep)) {
                                
                    } else {
                        return false;
                    }

                    for ($x=0; $x < 5; $x++) {
                        if($sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['images'][$x]['url'] != "") {
                            $imageUrl = $sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['images'][$x]['url'];
                            $imageDescription = $sleep['infonl']['nl']['categories'][3]['items'][$i]['items'][$d]['images'][$x]['description'];
                            $paramsImages = array(
                                'sleep_image_id' => $counterImages,
                                'sleep_image_url' => $imageUrl,
                                'sleep_image_description' => $imageDescription,
                                'fk_sleep' => $counterSleepItems,
                            );

                            if($this->sleepimages->insert($paramsImages)) {
                                
                            } else {
                                return false;
                            }
                            $counterImages++;
                        }
                    }
                    $counterSleepItems++;
                }
            } return false;
        }
        catch (Zend_Exception $exp) {
            echo 'End of the world in 20 seconds, fb-crashing, obama declares war with the human centipedes and oh yea, an error in sleep table: ' . $exp->getMessage();
            return false;
        }
    }
}
?>
