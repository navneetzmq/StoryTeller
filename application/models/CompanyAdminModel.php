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

        for($i=0; $i<count($dataToinsert); $i++){

            $this->db->insert('mapStaffStory', $dataToinsert[$i]);

        }

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
    
}

?>