<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CompanyAdminController extends CI_Controller {

      
    public function __construct() {
        
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('LoginModel');
        $this->load->model('SuperAdminModel');
        $this->load->library('session');
        $this->load->model('CompanyAdminModel');
    
    }

    // -------------- Load Add Staff Page --------------

    public function createStaff(){

        $userData = $this->session->userdata('userData');

        if($userData){
            $this->load->view('universal/uniHeader');
            $this->load->view('universal/uniMainBody');
            $this->load->view('companyAdmin/createStaff');
            $this->load->view('universal/uniFooter');
        }
        else{
            echo("Error in Staff creation");
        }


    }

    // Save staff data

    public function saveStaffData(){

        $userData = $this->session->userdata('userData');

        // For Table masterStaff
        
        $masterStaffData['companyId'] = $userData['companyId'];
        $masterStaffData['name'] = $this->input->post('empName');
        $masterStaffData['level'] = $this->input->post('empLevel');
        $masterStaffData['phone'] = $this->input->post('empNumber');
        $masterStaffData['email'] = $this->input->post('empEmail');
        $masterStaffData['DOB'] = $this->input->post('empDOB');
        $masterStaffData['address'] = $this->input->post('empAdd');
        $masterStaffData['isActive'] = 1;
        $masterStaffData['createdBy'] = $userData['staffId'];

        $empLevel = $masterStaffData['level'];

        // --------- For Table staffLoginCredential ------

        $empLoginData['loginId'] = $masterStaffData['email'];
        $empLoginData['password'] = $this->input->post('empPswd');         
        $empLoginData['level'] = $empLevel;
        $empLoginData['companyId'] = $userData['companyId'];       
        $empLoginData['isActive'] = 1;

        // -------------- For table staffLoginLog -------------

        $loginLogData['password'] = $empLoginData['password'];
        $loginLogData['isActive'] = '1';
    
        $this->CompanyAdminModel->storeEmpData($masterStaffData, $empLoginData, $loginLogData);

        $this->session->set_flashdata('add_company_admin', 'Employee Created');

        redirect(base_url('createStaff'));

    }

    // load page to add aaudience

    public function addAudience(){

        $userData = $this->session->userdata('userData');

        $staffId = $userData['staffId'];

        $companyId = $userData['companyId'];

        $story['storyData'] = $this->CompanyAdminModel->trainerStories($companyId, $staffId);


        // var_dump($storyData);
        // die();

        if(isset($userData)){

            $this->load->view('universal/uniHeader');
            $this->load->view('universal/uniMainBody');
            $this->load->view('companyAdmin/audience', $story); 
            $this->load->view('universal/uniFooter');
        
        }
        else{
            echo("Error: Filling Story dat data");
        }
    }

    // Save audidence data

    public function saveAudience(){

        $userData = $this->session->userdata('userData');

        $trainerId = $this->CompanyAdminModel->getStaffId($userData['loginId']);

        // var_dump($trainerId->staffId);
        // die();

        $audienceData['storyId'] = $this->input->post('storyId');
        $audienceData['trainerId'] = $trainerId->staffId;
        $audienceData['sessionId'] = ""; // UUID
        $audienceData['maleCount'] = $this->input->post('male');
        $audienceData['femaleCount'] = $this->input->post('female');
        $audienceData['location'] = $this->input->post('location');
        $audienceData['image'] = $this->input->post('image');

        $this->CompanyAdminModel->storeAudienceData($audienceData);

        $this->session->set_flashdata('add_company_admin', 'Successfull!, Audience has been Added.');

        redirect(base_url('audience'));

    }

    // Load assign stories to Trainer page

    public function assignStories(){

        $userData = $this->session->userdata('userData');

        $userCompany = $userData['companyId'];

        $staffData = $this->CompanyAdminModel->getStaffInfo($userCompany);

        $storyData = $this->CompanyAdminModel->getStoryByCompany($userCompany);

        $data = ['staffData'=>$staffData, 'storyData'=> $storyData];

        if(isset($userData)){

            $this->load->view('universal/uniHeader');
            $this->load->view('universal/uniMainBody');
            $this->load->view('companyAdmin/assignStory', $data);
            $this->load->view('universal/uniFooter');
        
        }
        else{
            echo("Error: Assigning Stories");
        }
    }

    // Get stories
    public function getStories(){
        $userData = $this->session->userdata('userData');
        $userCompany = $userData['companyId'];
        $storyData = $this->CompanyAdminModel->getStoryByCompany($userCompany);
        echo(json_encode($storyData));
    } 

    // Get assignable 
    public function getAssignedStories(){
        $trainerId = $this->input->post("trainerId");
        $assignedStories = $this->CompanyAdminModel->assignedStories($trainerId);
        echo(json_encode($assignedStories));
    }

    // Save assigned stories data

    public function saveAssignedStory(){

        $userData = $this->session->userdata('userData');

        $stfId = $this->input->post('trainerId');

        $storyId = $this->input->post('storyId');

        $storyIds = json_decode($storyId,true); // Array of storyId (selected checkboxes)

        // Get already assigned stories for corresponding TrainerId
        // $assignedStories = $this->CompanyAdminModel->assignedStories($stfId);

        // var_dump($assignedStories);
        // die();

        $dataToinsert=array();

        for($i = 0; $i < count($storyIds); $i++){

            $tempArr=['staffId'=>$stfId,'storyId'=>$storyIds[$i], 'isActive'=>'1'];

            $dataToinsert[$i]=$tempArr;
        }

        // var_dump($dataToinsert);
        // die();

        $this->CompanyAdminModel->saveAssignedStories($dataToinsert);

        $this->session->set_flashdata('add_company_admin', 'Successfull!, Stories Assigned.');

        // redirect(base_url('CompanyAdminController/assignStories'));

    }

    public function availableStories(){

        $userData = $this->session->userdata('userData');

        $staffId = $userData['staffId'];

        $companyId = $userData['companyId'];

        $story['storyData'] = $this->CompanyAdminModel->trainerStories($companyId, $staffId);

        if(isset($userData)){

            $this->load->view('universal/uniHeader');
            $this->load->view('universal/uniMainBody');
            $this->load->view('companyAdmin/trainerStories', $story);
            $this->load->view('universal/uniFooter');
        }

        else{
            echo("Error: Showing Stories");
        }

    }

    public function staffDetails(){

        $userData = $this->session->userdata('userData');

        $companyId = $userData['companyId'];

        $staff['staffData'] = $this->CompanyAdminModel->getStaffData($companyId);

        if(isset($userData)){

            $this->load->view('universal/uniHeader');
            $this->load->view('universal/uniMainBody');
            $this->load->view('companyAdmin/staffdetails', $staff);
            $this->load->view('universal/uniFooter');

        }

        else{
            echo("Error: Showing Staff Details");
        }

    }

    public function getStaffDetails(){

        $staffId = $this->input->post('staffId');

        $password = $this->CompanyAdminModel->getPassword($staffId);

        $staffData = $this->CompanyAdminModel->singleStaffData($staffId);
        
        $staffData['password'] = $password['password'];

        echo(json_encode($staffData));

    }

    public function updateStaffInfo(){

        $userData = $this->session->userdata('userData');
        $data['name'] = $this->input->post('emp_name');
        $data['phone'] = $this->input->post('emp_phone');
        $data['email'] = $this->input->post('emp_email');
        $data['address'] = $this->input->post('emp_address');
        $password = $this->input->post('emp_pswd');
        $staffId = $this->input->post('emp_Id');

        $toInsert['staffId'] = $staffId;
        $toInsert['password'] = $password;
        $toInsert['isActive'] = '1';

        $oldPswd = $this->CompanyAdminModel->getPassword($staffId);
        $this->CompanyAdminModel->updateStaffData($data, $toInsert, $staffId, $oldPswd['password']);

        $this->session->set_flashdata('add_company_admin', 'Details Updated!');
        redirect(base_url('staff'));
    }

    public function activeInactiveStaff(){

        $staffId = $this->input->post('staffId');
        $isActive = $this->input->post('isActive');

        $updated = $this->CompanyAdminModel->activeInActiveStaff($staffId, $isActive);

        echo $isActive;

    }

    // Start test
    public function startTest(){
        $this->load->view('universal/startTest');
    }

    // Load createGeneric
    public function loadGeneric(){
        $this->load->view('universal/uniHeader');
        $this->load->view('universal/uniMainBody');
        $this->load->view('companyAdmin/createGeneric');
        $this->load->view('universal/uniFooter');
    }

    // Save Generic Data
    public function saveGenericData(){
        $userData = $this->session->userdata('userData');
        $genericData['companyId'] = $userData['companyId'];
        $genericData['genericTitle'] = $this->input->post('genericTitle');
        $genericData['isActive'] = 1;
        $genericData['createdBy'] = $userData['staffId'];

        $this->CompanyAdminModel->submitGenericData($genericData);

        $this->session->set_flashdata('add_company_admin', 'Successfull!, Generic has been Created');

        redirect(base_url('generic'));
    }

    // To load Rule-Book
    public function loadRuleBook(){
        $list['storyData'] = $this->CompanyAdminModel->getStoryList();
        $list['genericData'] = $this->CompanyAdminModel->getGenericList();
        $this->load->view('universal/uniHeader');
        $this->load->view('universal/uniMainBody');
        $this->load->view('universal/ruleBook', $list);
        $this->load->view('universal/uniFooter');
    }

    // Fetch data from testLayout table using storyId
    public function getStoryTestLayout(){
        $storyId = $this->input->post('storyId');
        $testLayout = $this->CompanyAdminModel->storyTestLayout($storyId);
        echo(json_encode($testLayout));
    }

    // Fetch data from testLayout table using genericId
    public function getGenericTestLayout(){
        $genericId = $this->input->post('genericId');
        $testLayout = $this->CompanyAdminModel->genericTestLayout($genericId);
        echo(json_encode($testLayout));
    }

    // Submit ruleBook data
    public function saveRuleBookData(){
        $ruleData = array();
        $storyOrGeneric = $this->input->post('storyOrGeneric');
        if($storyOrGeneric == '1'){
            $ruleData['storyId'] = $this->input->post('storyId');
            $ruleData['genericId'] = "0";
        }
        else{
            $ruleData['genericId'] = $this->input->post('genericId');
            $ruleData['storyId'] = "0";
        }
        if($this->input->post('ansStatus') == "1"){
            $ruleData['showStatus'] = $this->input->post('ansStatus');
        }
        else{
            $ruleData['showStatus'] = "0";
        }
        if($this->input->post('reviewAns') == "1"){
            $ruleData['allowPrevious'] = $this->input->post('reviewAns');
        }
        else{
            $ruleData['allowPrevious'] = "0";
        }
        if($this->input->post('testTime') == "1"){
            $ruleData['testTime'] = $this->input->post('testTime');    
        }
        else{
            $ruleData['testTime'] = "0";
        }
        if($this->input->post('scoreBase') == "1"){
            $ruleData['distinctScore'] = $this->input->post('scoreBase');
        }
        else{
            $ruleData['distinctScore'] = "0";
        }
        if($this->input->post('autoplay') == "1"){
            $ruleData['autoplayAudio'] = $this->input->post('autoplay');
        }
        else{
            $ruleData['autoplayAudio'] = "0";
        }

        $this->CompanyAdminModel->submitRuleBookData($ruleData);
        $this->session->set_flashdata('add_company_admin', 'Rules are set Successfully!');
        redirect(base_url('rules'));
    }

}

?>