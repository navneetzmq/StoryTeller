<?php 

class LoginModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // To get login credentials

    public function getLoginData($loginData){
        
        // var_dump($loginData);
        // die();

        $this->db->select('*')
            ->from('staffLoginCredentials')
            ->where($loginData);
        $query = $this->db->get();
        
        if($query->num_rows() > 0){

            $result = $query->result()[0];

            if(isset($result->isActive)){

                return $data = [
                    "staffId" => $result->staffId,
                    "isActive" => $result->isActive,
                    "loginId" => $result->loginId,
                    "password" => $result->password,
                    "level" => $result->level,
                    "companyId" => $result->companyId
                ];
            }
            else{
           // echo "Error1";
           }
        }else{
            //echo "Error2";
        }
    }

    public function ckeckCompanyStatus($companyId){

        $this->db->select("isActive")
            ->from("masterCompany")
            ->where("companyId", $companyId);
        $query = $this->db->get();
        $status = $query->result_array()[0]['isActive'];
        return $status;

    }

}

?>