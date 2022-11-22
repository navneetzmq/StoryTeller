<?php 

class OpenPlayerModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Getting all public stories

    public function getPublicStories(){

        $query = $this->db->query('SELECT storyId, storyTitle FROM masterStory WHERE isPublic = 1');
        return $query->result();
        
    }

    // getting all  geneircs
    public function getAllGeneric(){
        $this->db->select('genericId, genericTitle')
            ->from('masterGeneric')
            ->where('isActive', 1);
        $query = $this->db->get();
        return $query->result();
    }

    // Store open Player data

    public function storeOpenPlayerData($openData){
        $this->db->insert('openPlayer', $openData);
    }

    // Get all questions by StoryId
    public function getStoryQuestions($storyId){
        $this->db->select('*')
            ->from('questionBank')
            ->where('storyId', $storyId);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get all questions by GenericId
    public function getGenericQuestions($genericId){
        $this->db->select('*')
            ->from('questionBank')
            ->where('genericId', $genericId);
        $query = $this->db->get();
        return $query->result_array();
    }

    // To save Test data in openPlayerInput table
    public function saveTestData($testData){
        $length = count($testData);
        // var_dump($testData);
        // die();
        $status = $this->saveMultipleRows($testData);
        if($status == $length){
            return true;
        }
        else{
            return false;
        }
    }

    private function saveMultipleRows($testData){
        $length = count($testData);
        $tmp = 0;
        for($i = 0; $i < $length; $i++){
            $this->db->insert('openPlayerInput', $testData[$i]);
            $tmp++;
        }
        return $tmp;
    }

    public function showResultData($decodedData){
        // Status of answers
        $statusArr = $this->getAnsStatus($decodedData);
        $length = count($statusArr);
        $score = 0;
        $countCorrect = 0;
        $title = 0;
        for($i = 0; $i < $length; $i++){
            if($statusArr[$i]->status){
                $score += $decodedData[$i]['score'];
                $countCorrect++;
            }
        }
        $storyId = $decodedData[0]['storyId'];
        $genericId = $decodedData[0]['genericId'];
        // Story Title
        if($storyId != 0){
            $title = $this->storyTitle($decodedData[0]['storyId']);
        }
        else if($genericId != 0){
            $title = $this->genericTitle($decodedData[0]['genericId']);
        }
        // Player name
        $playerName = $this->playerName($decodedData[0]['palyerId']);
        $resultData = array();
        $resultData['score'] = $score;
        $resultData['storyTitle'] = $title;
        $resultData['playerName'] = $playerName;
        $resultData['countCorrect'] = $countCorrect;
        return $resultData;
    }

    // To get answer status using SessionId and questionId
    private function getAnsStatus($decodedData){
        $length = count($decodedData);
        $statusArr = array();
        for($i = 0; $i < $length; $i++){
            $sessionId = $decodedData[$i]['sessionId'];
            $obj = new stdClass();
            $qId = $decodedData[$i]['questionId'];
            // Getting answer from questionBank (Real answer)
            $obj->questionId = $qId;
            $this->db->select('optNmbrForAns')
                ->from('questionBank')
                ->where('questionId', $qId);
            $query = $this->db->get();
            $realAns = $query->result_array()[0];

            // Getting answer from openPlayerInput (Player given answer)
            $this->db->select('answer')
                ->from('openPlayerInput')
                ->where('questionId', $qId)
                ->where('sessionId', $sessionId);
            $query1 = $this->db->get();
            $playerAns = $query1->result_array()[0];
            if($playerAns['answer'] == $realAns['optNmbrForAns']){
                $obj->status = true;
            }
            else{
                $obj->status = false;
            }
            $statusArr[$i] = $obj;
        }
        return $statusArr;
    }
    
    // To get story Title
    private function storyTitle($storyId){
        $this->db->select('storyTitle')
            ->from('masterStory')
            ->where('storyId', $storyId);
        $query = $this->db->get();
        return ($query->result_array()[0]['storyTitle']);
    }

    // To get generic title
    private function genericTitle($genericId){
        $this->db->select('genericTitle')
            ->from('masterGeneric')
            ->where('genericId', $genericId);
        $query = $this->db->get();
        return ($query->result_array()[0]['genericTitle']);
    }

    // To get Player name
    private function playerName($palyerId){
        $this->db->select('name')
            ->from('openPlayer')
            ->where('playerId', $palyerId);
        $query = $this->db->get();
        return ($query->result_array()[0]['name']);
    }

    // To get rules for story or generic
    public function getRulesData($storyId){
        $this->db->select('*')
            ->from('testLayout')
            ->where('storyId', $storyId);
        $query = $this->db->get();
        return ($query->result_array()[0]);
    }
}