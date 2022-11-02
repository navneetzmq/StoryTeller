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

    // Store open Player data

    public function storeOpenPlayerData($openData){

        $this->db->insert('openPlayer', $openData);

    }

    // Get all questions by StoryId
    public function getQuestions($storyId){
        $this->db->select('*')
            ->from('questionBank')
            ->where('storyId', $storyId);
        $query = $this->db->get();
        return $query->result_array();
    }

    // To save Test data in openPlayerInput table
    public function saveTestData($testData){
        $length = count($testData);
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
        for($i = 0; $i < $length; $i++){
            if($statusArr[$i]->status){
                $score += $decodedData[$i]['score'];
                $countCorrect++;
            }
        }
        // Story Title
        $storyTitle = $this->storyTitle($decodedData[0]['storyId']);
        // Player name
        $playerName = $this->playerName($decodedData[0]['palyerId']);
        $resultData = array();
        $resultData['score'] = $score;
        $resultData['storyTitle'] = $storyTitle;
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

    // To get Player name
    private function playerName($palyerId){
        $this->db->select('name')
            ->from('openPlayer')
            ->where('playerId', $palyerId);
        $query = $this->db->get();
        return ($query->result_array()[0]['name']);
    }
}