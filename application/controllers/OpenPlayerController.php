<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OpenPlayerController extends CI_Controller {

      
    public function __construct() {
        
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('OpenPlayerModel');
        // $this->load->model('LoginModel');
        // $this->load->model('SuperAdminModel');
        $this->load->library('session');
        // $this->load->model('CompanyAdminModel');
    }

    // ----------- Open Player self ---------

    public function openPlayer(){

        // $this->session->sess_destroy();

        $storyData['story'] = $this->OpenPlayerModel->getPublicStories();

        $this->load->view('universal/uniHeader');
        $this->load->view('universal/uniMainBody');
        $this->load->view('universal/openPlayer', $storyData);
        $this->load->view('universal/uniFooter');

    }

    // Save open Player data in openPlayer table

    public function saveOpenPlayerData(){
        $openData['playerId'] = (string)rand();
        $openData['storyId'] = $this->input->post('storyId');
        $openData['name'] = $this->input->post('openName');
        $openData['phone'] = $this->input->post('openNumber');       
        $openData['email'] = $this->input->post('openEmail');
        $openData['DOB'] = $this->input->post('openDOB');
        $openData['address'] = $this->input->post('openAdd');

        // Saving open player data
        $this->OpenPlayerModel->storeOpenPlayerData($openData);

        // Get all questions for selected(by Open player) story
        $questions['quesData'] = $this->OpenPlayerModel->getQuestions($openData['storyId']);
        $questions['playerId'] = $openData['playerId'];

        // Load StartTest page
        $this->load->view('universal/startTest', $questions);
    }   

    // Submitt test data
    public function submitTestdata(){
        $testData = $this->input->post('testData');
        $decodedData = json_decode($testData, true);
        $status = $this->OpenPlayerModel->saveTestData($decodedData);
        if($status){
            $resultData = $this->OpenPlayerModel->showResultData($decodedData);
        }
        echo(json_encode($resultData));
    }

    // Show test result or Srorecard
    public function showResult(){
        $this->load->view('universal/testResult');
    }

    // Session result OK
    public function resultOk(){
        $this->load->view('universal/uniHeader');
        $this->load->view('universal/uniLogin');
        $this->load->view('universal/uniFooter');
    }
}