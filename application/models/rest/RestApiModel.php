<?php

class RestApiModel extends CI_Model{

    public function __construct(){
        parent::__construct();

        $this->load->database();
    }

    // Get staffId using LoginId
    private function getStaffIdCompanyId($loginId){

        // var_dump($loginId);
        // die();

        $this->db->select('staffId, companyId')
            ->from('staffLoginCredentials')
            ->where('loginId', $loginId);
        $query = $this->db->get();
        return $query->result()[0];

    }

    // Get all available stories for trainer

    public function trainerStories($loginId){

        $staffData = $this->getStaffIdCompanyId($loginId);

        $staffId = $staffData->staffId;

        $companyId = $staffData->companyId;

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

        $this->db->select("storyId, storyTitle, isPublic")
            ->from("masterStory")
            ->where_in("storyId", $arr);
        $stories = $this->db->get();
        $stories = $stories->result_array();

        for($i = 0; $i < count($stories); $i++){

            $prePost = $this->getQuestions($stories[$i]['storyId']);

            $stories[$i]['staffId'] = $staffId;

            $stories[$i]['preQues'] = $prePost['pre'];

            $stories[$i]['postQues'] = $prePost['post'];
        }

        return $stories;

    }

    private function quesByStoryId($storyId){

        $this->db->select("questionId, questionText, isPre, isMCQ, optA, optB, optC, optD, optE, weight, answer, isActive")
        ->from("questionBank")
        ->where("storyId", $storyId);
    $questionBank = $this->db->get();
    return $questionBank->result_array();

    }

    public function getQuestions($storyId){

        $questionBank = $this->quesByStoryId($storyId);

        $arrPre = array();
        $preCount = 0;
        $arrPost = array();
        $postCount = 0;

        if($questionBank[0]['isActive'] == '1'){

            for($i = 0; $i < count($questionBank); $i++){

                if($questionBank[$i]['isPre'] == '1'){
    
                    $arrPre[$preCount] = [

                        'questionId' => $questionBank[$i]['questionId'],
                        'questionText' => $questionBank[$i]['questionText'],
                        'isMCQ' => $questionBank[$i]['isMCQ'],
                        'optA' => $questionBank[$i]['optA'],
                        'optB' => $questionBank[$i]['optB'],
                        'optC' => $questionBank[$i]['optC'],
                        'optD' => $questionBank[$i]['optD'],
                        'optE' => $questionBank[$i]['optE'],
                        'weight' => $questionBank[$i]['weight'],
                        'answer' => $questionBank[$i]['answer']
            
                    ];
                    $preCount++;
    
                }
                else{
    
                    $arrPost[$postCount] = [

                        'questionId' => $questionBank[$i]['questionId'],
                        'questionText' => $questionBank[$i]['questionText'],
                        'isMCQ' => $questionBank[$i]['isMCQ'],
                        'optA' => $questionBank[$i]['optA'],
                        'optB' => $questionBank[$i]['optB'],
                        'optC' => $questionBank[$i]['optC'],
                        'optD' => $questionBank[$i]['optD'],
                        'optE' => $questionBank[$i]['optE'],
                        'weight' => $questionBank[$i]['weight'],
                        'answer' => $questionBank[$i]['answer']

                    ];
                    $postCount++;
                    
                }
    
            }

            $qArr = [
    
                'pre' => $arrPre,
                'post' => $arrPost
    
            ];
    
            return $qArr;
        }
    }

    public function getPrePostQues($storyId){

        return $this->quesByStoryId($storyId);

    }


// Pre question data insertion
    public function submitStaffInputPre($dataToInsert){

        $this->db->insert('staffInput', $dataToInsert);
        return $this->db->affected_rows();
    }

// Post question data insertion
    public function submitStaffInputPost($dataToInsert){

        $this->db->insert('staffInput', $dataToInsert);
        return $this->db->affected_rows();

    }

    public function getAnswer($quesId){

        $this->db->select('answer, weight, isPre')
            ->from("questionBank")
            ->where("questionId", $quesId);
        $answer = $this->db->get();
        return $answer->result_array()[0];
    }

    public function countPreQuestions($storyId){

        $query = $this->db->query("SELECT COUNT(isPre) as total FROM questionBank WHERE isPre = '1' AND storyId = {$storyId}");
        return $query->result()[0]->total;
    }

    public function countPostQuestions($storyId){

        $query = $this->db->query("SELECT COUNT(isPre) as total FROM questionBank WHERE isPre = '0' AND storyId = {$storyId}");
        return $query->result()[0]->total;
    }
}

?>