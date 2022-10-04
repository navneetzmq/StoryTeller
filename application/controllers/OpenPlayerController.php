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

        $openData['storyId'] = $this->input->post('storyId');       
        $openData['name'] = $this->input->post('openName');
        $openData['phone'] = $this->input->post('openNumber');       
        $openData['email'] = $this->input->post('openEmail');
        $openData['DOB'] = $this->input->post('openDOB');
        $openData['address'] = $this->input->post('openAdd');
                
        $this->OpenPlayerModel->storeOpenPlayerData($openData);
    }
    
}