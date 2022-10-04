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

}