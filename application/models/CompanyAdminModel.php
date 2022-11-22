<?php 

class CompanyAdminModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // To store Staff Data

    public function storeEmpData($masterStaffData, $empLoginData, $loginLogData){

        // Store in masterStaff
        $this->db->insert('masterStaff', $masterStaffData);

        $staffId = $this->db->insert_id();
        $empLoginData['staffId'] = $staffId;

        // store in staffLoginCredentials
        $this->db->insert('staffLoginCredentials', $empLoginData);

        // store in staffLoginLog
        $loginLogData['staffId'] = $staffId;
        $this->db->insert('staffLoginLog', $loginLogData);

    }

    public function storeCompanyAdminData($masterStaffData, $empLoginData, $loginLogData){

        // Store in masterStaff
        $this->db->insert('masterStaff', $masterStaffData);

        $staffId = $this->db->insert_id();
        $empLoginData['staffId'] = $staffId;

        // store in staffLoginCredentials
        $this->db->insert('staffLoginCredentials', $empLoginData);

        // store in staffLoginLog
        $loginLogData['staffId'] = $staffId;
        $this->db->insert('staffLoginLog', $loginLogData);

        // Update adminId in masterCompany table
        $companyId = $masterStaffData['companyId'];
        $data = [
                'adminId' => $staffId
            ];
        $this->db->where('companyId', $companyId);
        $this->db->update('masterCompany', $data);

    }

    // To get staffId using LoginId

    public function getStaffId($loginId){

        $query = $this->db->query("SELECT staffId from staffLoginCredentials WHERE loginId = '{$loginId}'");
        return $query->result()[0];

    }

    // To store audience data

    public function storeAudienceData($audienceData){

        $this->db->insert('audience', $audienceData);

    }

    // To get staff Info using company Id and Level

    public function getStaffInfo($userCompany){

        $query = $this->db->query("SELECT staffId, name FROM masterStaff where companyId = '{$userCompany}' AND level = '3'");

        return $query->result();

    }

    // To save assign stories to trainer

    public function saveAssignedStories($dataToinsert){

        $trainerId = $dataToinsert[0]['staffId'];
        $arrCount = count($dataToinsert);

        for($i=0; $i < $arrCount; $i++){
            $storyId = $dataToinsert[$i]['storyId'];
            $rows = $this->checkIfStoryAssigned($trainerId, $storyId);

            if($rows == 0){
                $this->db->insert('mapStaffStory', $dataToinsert[$i]);
            }
        }
    }

    private function checkIfStoryAssigned($trainerId, $storyId){
        $this->db->select('*')
            ->from('mapStaffStory')
            ->where('staffId',  $trainerId)
            ->where('storyId', $storyId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // get assigned stories
    public function assignedStories($trainerId){

        $this->db->select('storyId')
            ->from('mapStaffStory')
            ->where('staffId', $trainerId);
        $query = $this->db->get();
        return $query->result_array();
    }

    // To get Story information using Comapny Id

    public function getStoryByCompany($userCompany){

        $query = $this->db->query("SELECT storyId, storyTitle, isPublic FROM masterStory where companyId = {$userCompany} AND isPublic = 0");

        return $query->result();

    }

    // get Stories for trainer (assigned + [company's Public stories])

    public function trainerStories($companyId, $staffId){

        // getting storyId from mapStaffStory (Assigned)
        $this->db->select("storyId")
            ->from("mapStaffStory")
            ->where("staffId", $staffId);
        $query1 = $this->db->get();    
      
        $result1 = $query1->result_array();  //Array

        $this->db->select("storyId")
            ->from("masterStory")
            ->where("companyId", $companyId)
            ->where("isPublic", 1);
        $query2 = $this->db->get();
      
        $result2 = $query2->result_array();  //Array

        // Merging arrays without duplicate
        $result = array_unique(array_merge($result1,$result2), SORT_REGULAR);

        // getting all available stories for a Trainer

        $arr = array();

        for($i = 0; $i < count($result); $i++){

            $arr[$i] = $result[$i]['storyId'];

        }

        $this->db->select("storyId, storyTitle, isPublic, prePostQues")
            ->from("masterStory")
            ->where_in("storyId", $arr);
        $stories = $this->db->get();

        return $stories->result();

    }

    // Get complete staff data

    public function getStaffData($companyId){

        $this->db->select('*')
            ->from('masterStaff')
            ->where('companyId', $companyId);
        $query = $this->db->get();

        return $query->result();

    }

    public function singleStaffData($staffId){

        $this->db->select('staffId, name, phone, email, address')    
            ->from('masterStaff')
            ->where('staffId', $staffId);   
        $query = $this->db->get();

        return $query->result_array()[0];

    }

    public function updateStaffData($data, $toInsert, $staffId, $oldPswd){

        $login['loginId'] = $data['email'];
        $password['password'] = $toInsert['password'];

        // Update in masterStaff
        $this->db->where('staffId', $staffId);
        $this->db->update('masterStaff', $data);

        // Update in staffLoginCredentials
        $this->db->where('staffId', $staffId);
        $this->db->update('staffLoginCredentials', $login);

        if($oldPswd != $password['password']){

            // Update password in staffLoginCredentials
            $this->db->where('staffId', $staffId);
            $this->db->update('staffLoginCredentials', $password);

            // Deactivate old password staffLoginLog
            $this->db->set('isActive', 0);
            $this->db->where('staffId', $staffId);
            $this->db->update('staffLoginLog');

            // insert new row in staffLoginLog
            $this->db->insert('staffLoginLog', $toInsert);

        }
    }

    public function getPassword($staffId){

        $this->db->select('password')    
            ->from('staffLoginCredentials')
            ->where('staffId', $staffId);   
        $query = $this->db->get();

        return $query->result_array()[0];
    }

    public function activeInActiveStaff($staffId, $isActive){

        if($isActive == 1){
            $data = [
                'isActive' => 0
            ];
            // Update in masterStaff
            $this->db->where('staffId', $staffId);
            $this->db->update('masterStaff', $data);

            // Update in staffLoginCredentials
            $this->db->where('staffId', $staffId);
            $this->db->update('staffLoginCredentials', $data);
            
            return true;
        }
        else{
            $data = [   
                'isActive' => 1
            ];
            // Update in masterStaff
            $this->db->where('staffId', $staffId);
            $this->db->update('masterStaff', $data);    

            // Update in staffLoginCredentials
            $this->db->where('staffId', $staffId);
            $this->db->update('staffLoginCredentials', $data);

            return true;
        }

    }

    // Submit generic Data
    public function submitGenericData($genericData){
        $this->db->insert('masterGeneric', $genericData);
    }

    // To fetch list of stories from masterStory Table
    public function getStoryList(){
        $this->db->select('*')    
            ->from('masterStory');
        $query = $this->db->get();
        return $query->result();
    }

    // To fetch list of Generics from masterGeneric Table
    public function getGenericList(){
        $this->db->select('*')    
            ->from('masterGeneric');
        $query = $this->db->get();
        return $query->result();
    }

    // Fetch data from testLayout table using storyId
    public function storyTestLayout($storyId){
        $this->db->select('*')    
            ->from('testLayout')
            ->where('storyId', $storyId);
        $query = $this->db->get();
        return $query->result()[0];
    }
    // Fetch data from testLayout table using genericId
    public function genericTestLayout($genericId){
        $this->db->select('*')
            ->from('testLayout')
            ->where('genericId', $genericId);
        $query = $this->db->get();
        return $query->result()[0];
    }

    // Submit RuleBook datda in testLayout table
    public function submitRuleBookData($ruleData){
        $this->db->select('storyId, genericId')    
            ->from('testLayout');
        $query = $this->db->get();
        $storyGenericId = $query->result_array();
        $arrLength = count($storyGenericId);
        $storyExists = 0;
        $genericExists = 0;
        for($i = 0; $i < $arrLength; $i++){
            if($storyGenericId[$i]['storyId'] == $ruleData['storyId']){
                $storyExists++;
            }
            if($storyGenericId[$i]['genericId'] == $ruleData['genericId']){
                $genericExists++;
            }
        }

        // insert or Update story rule
        if(($storyExists != 0) && ($ruleData['storyId']) != "0"){
            // update row story rule
            $this->db->where('storyId', $ruleData['storyId']);
            $this->db->update('testLayout', $ruleData);
        }
        else if(($storyExists == 0) && ($ruleData['storyId']) != "0"){
            // insert row story rule
            $this->db->insert('testLayout', $ruleData);
        }

        // insert or Update story rule
        else if(($genericExists != 0) && ($ruleData['genericId']) != "0"){
            // update row generic rule
            $this->db->where('genericId', $ruleData['genericId']);
            $this->db->update('testLayout', $ruleData);
        }
        else if(($genericExists == 0) && ($ruleData['genericId']) != "0"){
            // insert row generic rule
            $this->db->insert('testLayout', $ruleData);
        }
    }
}
?>