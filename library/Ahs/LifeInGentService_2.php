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
    protected $admin;
    
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
        $this->hospitals = new Application_Model_DbTable_HospitalsTable();
        
        $ziekenhuizen = json_decode(file_get_contents('http://data.appsforghent.be/poi/ziekenhuizen.json'), true);
        
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
            print_r('hospitals deleted!');
            $this->hospitals->delete();
        } else {
            print_r('NOT deleted!!!!!!!!');
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
            
            $this->hospitals->insert($params);
        }    
        
        return $checkname;
    }
    
    


    public function updatePrimarySchools() 
    {
        $this->primaryschools = new Application_Model_DbTable_PrimaryschoolTable();
        
        $primarys = json_decode(file_get_contents('http://data.appsforghent.be/poi/basisscholen.json'), true);
       
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
            print_r('Primary schools deleted!');
            $this->primaryschools->delete();
        } else {
            print_r('NOT deleted!!!!!!!!');
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
            
            if($this->primaryschools->insert($params)){
                return true;
            }
            else{
                return false;
            }
        }
        return false;
    }
    
    public function updateYouthOrganisations() 
    {
        $this->youthorganisations = new Application_Model_DbTable_YouthorganisationTable();
        
        $youthorganisations = json_decode(file_get_contents('http://data.appsforghent.be/poi/jeugdwerk.json'), true);
       
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
            print_r('Youth organisations deleted!');
            $this->youthorganisations->delete();
        } else {
            print_r('NOT deleted!!!!!!!!');
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
            
            $this->youthorganisations->insert($params);
        }        
    }
    
    public function updatePOI() 
    {
        $this->poi = new Application_Model_DbTable_PoiTable();
        
        $pois = json_decode(file_get_contents('http://data.appsforghent.be/toerisme/infonl.json'), true);
        $categorysPOI = $pois['infonl']['nl']['categories'][1]['items'];

        $c = count($pois['infonl']['nl']['categories'][1]['items']);

        $checkname = $categorysPOI[0]['items'][0]['title'];
        if($checkname!= ""){
            print_r('POIs deleted!');
            $this->poi->delete();
        } else {
            print_r('NOT deleted!!!!!!!!');
        }
        
        $counter = 1;
        
        for ($i=0; $i < $c; $i++)
        {
            $ItemsInCategory = count($categorysPOI[$i]['items']);
            //print_r(' with title: ' . $categorysPOI[$i]['title']);
            $category = $i;
            for ($b=0; $b < $ItemsInCategory; $b++)
            {
                $id = $counter;
                $name = $categorysPOI[$i]['items'][$b]['title'];
                $description = $categorysPOI[$i]['items'][$b]['info'];
                
                $params = array(
                    'poi_id' => $id,
                    'poi_category' => $category,
                    'poi_name' => $name,
                    'poi_description' => $description,
                );
            
                $this->poi->insert($params);
                
                $counter++;
            }
            //print_r($i . ' de categorie naam is: ' . $POICategoryName);
        }   
        
        
    }
}

?>
