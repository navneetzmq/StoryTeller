<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class TrainerLoginStoriesController extends RestController{

	public function __construct(){

		parent::__construct();
        $this->load->helper('url');
        $this->load->model('LoginModel');
        $this->load->model('CompanyAdminModel');
        $this->load->model('rest/RestApiModel');

	}

    // ------- Action Method -------

    public function userAuthentication_post(){

        $json = file_get_contents('php://input'); // get input data in json format

        $jsonDecoded = json_decode($json, true); // decoding json in array format with true parameter
        $loginData['loginId'] = $jsonDecoded['loginId'];
        $loginData['password'] = $jsonDecoded['loginPswd'];
        
        $loginId = $loginData['loginId'];

        $user = $this->validateUserInput($loginData);
  
        $storyArr = array();

        if(isset($user)){

            $storyArr = $this->availableStories($loginId);

        }

        echo json_encode($storyArr);
        die();
    }

    public function questionsByStoryId_post(){

        $json = file_get_contents('php://input'); // get input data in json format

        $jsonDecoded = json_decode($json, true); // decoding json in array format with true parameter
        $storyId = $jsonDecoded['storyId'];

        if(isset($storyId)){

            $questions = $this->RestApiModel->getQuestions($storyId);

        }

        echo json_encode($questions);
    }

    // ---- Validate user Input (LoginId and Password) ----

    private function validateUserInput($loginData){

        $isValid = $this->LoginModel->getLoginData($loginData);

        if(isset($isValid)){
 
            if($loginData['loginId'] === $isValid['loginId'] && $loginData['password'] === $isValid['password']){

                if(isset($isValid['isActive']) == 1){

                   return TRUE;

                }
                else{

                    return NULL;
                }                        
            }
        }
    }

    // ------ Get assigned stories to user -------

    private function availableStories($loginId){

        $story = $this->RestApiModel->trainerStories($loginId);

        return $story;

    }

    private function trainerSessionInput($storyArr, $staffId, $storyId){

        for($i = 0; $i < count($storyArr); $i++){

            // echo json_encode($storyArr[$i]);
            // die();

            if($storyArr[$i]['storyId'] == $storyId){

                $preQuesArr = $storyArr[$i]['preQues'];
                $postQuesArr = $storyArr[$i]['postQues'];

                $quesArr = array();

                $quesArr = array_merge($preQuesArr, $postQuesArr);

                return $quesArr;

            }

        }

    }

    private function getAnswer($quesId){

        return $this->RestApiModel->getAnswer($quesId);

    }

    public function submitSessionData_post(){

        $json = file_get_contents('php://input'); // get input data in json format
        $jsonDecoded = json_decode($json, true); // decoding json in array format with true parameter

        $staffId =  $jsonDecoded[0]['staffId'];
        $storyId = $jsonDecoded[0]['storyId'];

        // $satffSessionData = array();
        // $satffSessionData['staffId'] = $staffId;
        // $satffSessionData['storyId'] = $storyId;
        // $satffSessionData['isGroup'] = '1';
        // $satffSessionData['startTime'] = 
        // $satffSessionData['endTime'] = 
        // $satffSessionData['preTestStartTime'] = 
        // $satffSessionData['isPreComplete'] = 
        // $satffSessionData['storyStartTime'] = 
        // $satffSessionData['isStoryComplete'] = 
        // $satffSessionData['postTestStartTime'] = 
        // $satffSessionData['isPostComplete'] = 
        // $this->db->set('sessionUUID', 'UUID()', FALSE);

        $countPre = 0;
        $countPost = 0;

        // ---------- Save data in staffInput table -------

        // Pre Questions Data Insertion
        for($i = 0; $i < count($jsonDecoded); $i++){

            $quesId = $jsonDecoded[$i]['questionId'];
            $quesDetail = $this->getAnswer($quesId); // Calling function to get answer details
            if($quesDetail['isPre'] == '1'){

                $dataToInsert = array();
                $dataToInsert['sessionUUID'] = '0';
                $dataToInsert['questionId'] = $quesId;
                $dataToInsert['storyId'] = $storyId;
                $dataToInsert['staffId'] = $staffId;
                $dataToInsert['answer'] = $jsonDecoded[$i]['answer'];

                if($quesDetail['answer'] == $jsonDecoded[$i]['answer']){
                    $dataToInsert['ansStatus'] = '1';
                }
                else{
                    $dataToInsert['ansStatus'] = '0';
                }

                $dataToInsert['score'] = $quesDetail['weight'];

                $countPre = $countPre + ($this->RestApiModel->submitStaffInputPre($dataToInsert));

            }
            
        }

        $getCountPre = $this->RestApiModel->countPreQuestions($storyId);

        if($countPre == $getCountPre){

            echo "Pre Test Completed   ";

            for($j = 0; $j < count($jsonDecoded); $j++){

                $quesId = $jsonDecoded[$j]['questionId'];
                $quesDetail = $this->getAnswer($quesId); // Calling function to get answer details
                if($quesDetail['isPre'] == '0'){

                    $dataToInsert = array();
                    $dataToInsert['sessionUUID'] = '0';
                    $dataToInsert['questionId'] = $quesId;
                    $dataToInsert['storyId'] = $jsonDecoded[$j]['storyId'];
                    $dataToInsert['staffId'] = $jsonDecoded[$j]['staffId'];
                    $dataToInsert['answer'] = $jsonDecoded[$j]['answer'];
     
                    if($quesDetail['answer'] == $jsonDecoded[$j]['answer']){
                        $dataToInsert['ansStatus'] = '1';
                    }
                    else{
                        $dataToInsert['ansStatus'] = '0';
                    }
    
                    $dataToInsert['score'] = $quesDetail['weight'];
    
                    $countPost = $countPost + ($this->RestApiModel->submitStaffInputPost($dataToInsert));

                }
                
            }

            $getCountPost = $this->RestApiModel->countPostQuestions($storyId);

            if($countPost == $getCountPost){
                echo "Post Test Completed";
            }
            else{
                echo "Post Test not Completed";
            }
        }
        else{
            echo "Pre Test not Completed   ";
        }
    }
}

?>