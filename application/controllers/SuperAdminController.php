<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SuperAdminController extends CI_Controller {

      
    public function __construct() {
        
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('LoginModel');
        $this->load->model('SuperAdminModel');
        $this->load->model('CompanyAdminModel');
        $this->load->library('session');
        $this->load->library('upload');
    
    }

    // -------------- Create a company --------------

    public function createCompany(){

        $userData = $this->session->userdata('userData');

        if($userData){
            $this->load->view('universal/uniHeader');
            $this->load->view('universal/uniMainBody');
            $this->load->view('superAdmin/createCompany');
            $this->load->view('universal/uniFooter');
        }
        else{
            echo("Error in company creation");
        }

    }

    // Save company admin data

    public function saveCompanyAdminData(){

        $userData = $this->session->userdata('userData');

        // --------- For Table masterStaff ------------

        $masterStaffData['companyId'] =  $this->input->post('companyId');
        $masterStaffData['name'] = $this->input->post('empName');
        $masterStaffData['phone'] =  $this->input->post('empNumber');
        $masterStaffData['email'] = $this->input->post('empEmail');
        $masterStaffData['DOB'] = $this->input->post('empDOB');
        $masterStaffData['address'] = $this->input->post('empAdd');
        $masterStaffData['isActive'] = 1;
        $masterStaffData['level'] = 1;
        $masterStaffData['createdBy'] = $userData['staffId'];

        // --------- For Table staffLoginCredential (Company Admin) ------

        $adminLoginData['loginId'] = $masterStaffData['email'];
        $adminLoginData['password'] = $this->input->post('empPswd');        
        $adminLoginData['level'] = 1;
        $adminLoginData['isActive'] = 1;
        $adminLoginData['companyId'] = $this->input->post('companyId');
        $companyAdminLevel = $adminLoginData['level'];  
        $companyAdminLoginId =  $adminLoginData['loginId'];

        // ---------- For login Log ----------
        $loginLogData['password'] = $adminLoginData['password'];
        $loginLogData['isActive'] = '1';
        
        // Saving data in masterStaff and staffLoginCredential
        $this->CompanyAdminModel->storeCompanyAdminData($masterStaffData, $adminLoginData, $loginLogData);

        $this->session->set_flashdata('add_company_admin', 'Admin Assigned');
        redirect(base_url('company'));

    }

    // To Save company data

    public function saveCompanyData(){

        $userData = $this->session->userdata('userData');

        // -------- For Table masterCompany ---------

        $companyData['companyName'] = $this->input->post('companyName');
        $companyData['phone'] = $this->input->post('companyContact');
        $companyData['email'] = $this->input->post('companyEmail');
        $companyData['location'] = $this->input->post('companyLocation');   
        $companyData['isActive'] = 1;
        $companyData['createdBy'] = $userData['staffId'];    
        $this->SuperAdminModel->storeCompanyData($companyData);

        $this->session->set_flashdata('add_company_admin', 'Company Created');

        redirect(base_url('createCompany'));
    }

    // ------------ Create Story ---------

    public function createStory(){

        $userData = $this->session->userdata('userData');

        if(isset($userData)){
            $this->load->view('universal/uniHeader');
            $this->load->view('universal/uniMainBody');
            $this->load->view('universal/createStory');
            $this->load->view('universal/uniFooter');
        }
        else{
            echo("Error in Story creation");
        }

    }

    // To save Story data in masterStory table

    public function saveStoryData(){

        $userData = $this->session->userdata('userData');

        $storyData['companyId'] = $userData['companyId'];
        $storyData['storyTitle'] = $this->input->post('storyTitle');
        $storyData['prePostQues'] = $this->input->post('quesType');
        $storyData['isActive'] = 1;
        $storyData['isPublic'] = $this->input->post('storyType');
        $storyData['createdBy'] = $userData['staffId'];

        $this->SuperAdminModel->storeStoryData($storyData);

        $this->session->set_flashdata('add_company_admin', 'Successfull!, Story has been Created');

        redirect(base_url('createStory'));

    }

    // Creating a question

    public function createQuestion(){

        $userData = $this->session->userdata('userData');

        $staffId = $userData['staffId'];

        $storyData['storyData'] = $this->SuperAdminModel->getStoryData($staffId);

        // var_dump($storyData);

        if(isset($userData)){
            $this->load->view('universal/uniHeader');
            $this->load->view('universal/uniMainBody');
            $this->load->view('universal/createQuestion', $storyData);
            $this->load->view('universal/uniFooter');
        }
        else{
            echo("Error in Story creation");
        }

    }

    // To save question data in questionBank table

    public function saveQuestionData(){

        $userData = $this->session->userdata('userData');
        $questionData['storyId'] = $this->input->post('storyId');
        $questionData['isPre'] = $this->input->post('isPreValue');
        $questionData['companyId'] = $userData['companyId'];            
        $questionData['qText'] = $this->input->post('question');
        $questionData['qImage'] = $this->uploadImageFile('questionImage'); //Function call   
        $questionData['qAudio'] = $this->uploadAudioFile('questionAudio');
        $questionData['hasScore'] = $this->input->post('hasScore');        
        $questionData['isMCQ'] = $this->input->post('quesType');
        $questionData['opt1'] = $this->input->post('optA');
        $questionData['optImage1'] = $this->uploadImageFile('optAImage');
        $questionData['optAudio1'] = $this->uploadAudioFile('optAAudio');
        $questionData['opt2'] = $this->input->post('optB');
        $questionData['optImage2'] = $this->uploadImageFile('optBImage');
        $questionData['optAudio2'] = $this->uploadAudioFile('optBAudio');
        $questionData['opt3'] = $this->input->post('optC');
        $questionData['optImage3'] = $this->uploadImageFile('optCImage');
        $questionData['optAudio3'] = $this->uploadAudioFile('optCAudio');
        $questionData['opt4'] = $this->input->post('optD');
        $questionData['optImage4'] = $this->uploadImageFile('optDImage');
        $questionData['optAudio4'] = $this->uploadAudioFile('optDAudio');
        $questionData['opt5'] = $this->input->post('optE');
        $questionData['optImage5'] = $this->uploadImageFile('optEImage');
        $questionData['optAudio5'] = $this->uploadAudioFile('optEAudio');
        $questionData['weight'] = $this->input->post('weight');
        $questionData['isActive'] = '1';
        $questionData['createdBy'] = $userData['staffId'];
        $singleAns = $this->input->post('selectAnsRadio');
        $noOfOptions = $this->input->post('option');
        $quesType = $this->input->post('quesType');
        $questionData['optNmbrForAns'] = "";

        if($quesType == 0){
            $questionData['optNmbrForAns'] = $singleAns;
        }
        else{
            for($i = 0; $i < $noOfOptions; $i++){
                $multyAns = $this->input->post('ansCid'.($i+1));
                if($multyAns){
                    $questionData['optNmbrForAns'] .= $multyAns;
                    $questionData['optNmbrForAns'] .= ",";
                }
            }
        }
        $questionData['optNmbrForAns'] = trim($questionData['optNmbrForAns'],",");
        
        $this->SuperAdminModel->storeQuestionData($questionData);

        $this->session->set_flashdata('add_company_admin', 'Successfull!, Question has been added to Story');

        redirect(base_url('createQuestion'));
    }

    // Upload Image
    private function uploadImageFile($name){

        $config['upload_path'] = './assets/uploadedData/images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 0;
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);
        if($this->upload->do_upload($name)){
            $upload_data = $this->upload->data();
            $randomName = $upload_data['file_name'];
            $path = "assets/uploadedData/images/".$randomName;
            return $path;
        }
        else{
            return "";
        }
    }

    // Upload Audio
    private function uploadAudioFile($name){

        $config['upload_path'] = './assets/uploadedData/Audio/';
        $config['allowed_types'] = 'wav|mp3|m4a|wma|mp4';
        $config['max_size'] = 0;
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);
        if($this->upload->do_upload($name)){

            $upload_data = $this->upload->data();
            $randomName = $upload_data['file_name'];
            $path = "assets/uploadedData/Audio/".$randomName;
            return $path;
        } 
        else{
            return "";
        }  
    }

    // To see company list for superAdmin

    public function companyList(){

        $userData = $this->session->userdata('userData');

        $companies['companyData'] = $this->SuperAdminModel->getCompanyList();

        if(isset($userData)){
            $this->load->view('universal/uniHeader');
            $this->load->view('universal/uniMainBody');
            $this->load->view('superAdmin/companyList', $companies);
            $this->load->view('universal/uniFooter');
        }
        else{
            echo("Error in Story creation");
        }
    }

    public function checkStoryHasPreQues(){

        $storyId = $this->input->post('storyId');

        $prePostQues = $this->SuperAdminModel->checkStoryHasPreOrPostQues($storyId);

        echo json_encode($prePostQues);

    }

    public function activeInActiveCompany(){

        $companyId = $this->input->post('companyId');
        $isActive = $this->input->post('isActive');

        $updated = $this->SuperAdminModel->activeInActiveCompany($companyId, $isActive);

        echo $isActive;

    }
}

?>
