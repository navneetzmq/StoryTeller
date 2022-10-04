<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginController extends CI_Controller {
      
    public function __construct() {
        
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('LoginModel');
        $this->load->library('session');
    
    }

    // Loading the Universal Login Page
    public function login(){

        $this->load->view('universal/uniHeader');
        $this->load->view('universal/uniLogin');
        $this->load->view('universal/uniFooter');

    }

    // Submit the universal login form
    public  function submitLogin()
    {
 
        $loginData['loginId'] = $this->input->post('loginId');
        $loginData['password'] = $this->input->post('loginPswd');

        $isValid = $this->LoginModel->getLoginData($loginData);

        $companyStatus = $this->LoginModel->ckeckCompanyStatus($isValid['companyId']);

        if($companyStatus == '1'){
            
            if(isset($isValid)){
 
                $userData = [                
                    'loginId' => ($isValid['loginId']),
                    'level'	=> ($isValid['level']),
                    'isActive' => ($isValid['isActive']),
                    'staffId' => ($isValid['staffId']),
                    'companyId' => ($isValid['companyId'])
                ];
    
                // Set Session For login User
                
                $this->session->set_userdata('userData', $userData);
    
                if($loginData['loginId'] === $isValid['loginId'] && $loginData['password'] === $isValid['password']){
    
                    if(isset($isValid['isActive']) == 1 && $userData['isActive'] == 1){
    
                        $this->load->view('universal/uniHeader');            
                        $this->load->view('universal/uniMainBody', $userData);
                        $this->load->view('universal/uniFooter');
    
                    }
                    else{                            
                        echo("Invalid: You're inactive");                       
                    }                        
                }
            }     
        }
        else{
            echo("Invalid: Employee of inert company can not be LoggedIn!");
        }
    }

    // To Log Out

    public function logout(){
        
        $this->session->unset_userdata('loginId');
        $this->load->view('universal/uniHeader');
        $this->load->view('universal/uniLogin');
        $this->load->view('universal/uniFooter');
        
    }

    // To Sidebar

    public function dashboard(){

        $this->load->view('universal/uniHeader');
        $this->load->view('universal/uniMainBody');
        $this->load->view('universal/uniFooter');

    }
}

?>