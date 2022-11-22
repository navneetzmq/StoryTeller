
<?php 

class SuperAdminModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // To store company and Company admin data in three tables

    public function storeCompanyData($companyData){      

        $this->db->insert('masterCompany', $companyData);

    }

    // To store story Data

    public function storeStoryData($storyData){

        $this->db->insert('masterStory', $storyData);

    }

    // to getting story data using Staff Id

    public function getStoryData($staffId){

        $this->load->model('rest/RestApiModel');

        $query = $this->db->query("SELECT storyId, storyTitle, isPublic FROM masterStory where createdBy = {$staffId}");

        $stories = $query->result();

        for($i = 0; $i < count($stories); $i++){

            $storyId = $stories[$i]->storyId;
    
            $pre = $this->RestApiModel->countPreQuestions($storyId);
            if(isset($pre)){
                $stories[$i]->totalPre = $pre;
            }

            $post = $this->RestApiModel->countPostQuestions($storyId);
            if(isset($post)){
                $stories[$i]->totalPost = $post;
            }
        }
        return $stories;
    }

    // to get generic data
    public function getGenericData($staffId){
        $this->db->select('genericId, genericTitle, isActive')
            ->from('masterGeneric')
            ->where('createdBy', $staffId);
        $query = $this->db->get();
        return $query->result();
    }

    // To store question data

    public function storeQuestionData($questionData){

        $this->db->insert('questionBank', $questionData);

    }

    // To get question data by id
    public function getQuestionData($quesId){
        $this->db->select('*')
            ->from('questionBank')
            ->where('questionId', $quesId);
        $query = $this->db->get();
        return $query->result_array()[0];
    }

    // To store Editted question data
    public function editQuesData($updatedQuesData, $quesId){
        $this->db->where('questionId', $quesId);
        $this->db->update('questionBank', $updatedQuesData);
    } 

    // To get company list for SuperAdmin
    public function getCompanyList(){
        $adminId = array('5');
        $this->db->select('companyId, adminId, companyName, location, email, isActive, createdDateTime')
            ->from('masterCompany')
            ->where_not_in('adminId', $adminId);
        $query = $this->db->get();
        return $query->result();
    }

    // Company list without admin
    public function companyWithNoAdmin(){

        $this->db->select('companyId, companyName')
            ->from('masterCompany')
            ->where('adminId', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function checkStoryHasPreOrPostQues($storyId){

        // var_dump($storyId);

        $this->db->select('prePostQues')
            ->from('masterStory')
            ->where('storyId', $storyId);
        $query = $this->db->get();
        return $query->result()[0];

    }

    // Update 'isActive' in masterCompany table
    public function activeInActiveCompany($companyId, $isActive){

        if($isActive == 1){
            $data = [
                'isActive' => 0
            ];
            $this->db->where('companyId', $companyId);
            $this->db->update('masterCompany', $data);
            
            return true;
        }
        else{
            $data = [   
                'isActive' => 1
            ];
            $this->db->where('companyId', $companyId);
            $this->db->update('masterCompany', $data);

            return true;
        }
    }

    // Get Company Admin details
    public function getCompanyAdmin($companyId){
        $this->db->select('name, phone, email, address')
            ->from('masterStaff')
            ->where('companyId', $companyId)
            ->where('level', 1);
        $query = $this->db->get();
        return $query->result_array()[0];
    }
}

?>
