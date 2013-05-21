<?php

require_once('vendor/codebird/codebird.php');


class Twitter_account extends CI_Model {

    private $tableName = 'twitter_accounts';
    private $codebirdDriver = null;

    /****
    *
    *
    *
    */
    function __construct() {
        
        parent::__construct();
        Codebird::setConsumerKey('ObsgXezMYo9x5wtcqktEQ', '13iug2CqVj5ewthjFiISfsiyKUzP96Ld99ntA78Zo');
        $this->codebirdDriver = Codebird::getInstance(); 
    }

    /****
    *
    *
    *
    */
    public function verifyUserOwnership($userID, $twitterAccountID) {
        
        $this->db->where('user_id', $userID);
        $this->db->where('id', $twitterAccountID);

        $twitterAccounts = $this->db->get($this->tableName);

        if($twitterAccounts->num_rows() == 0) {
            return false;    
        }

        return true;
    }

    /****
    *
    *
    *
    */
    public function getByID($accountID) {
    
        $this->db->where('id', $accountID);
        $twitterAccounts = $this->db->get($this->tableName);

        if($twitterAccounts->num_rows() == 0) {
            return false;    
        }

        $results = $twitterAccounts->result_array();
        return $results[0];
    }
    
    /****
    *
    *
    *
    */
    public function getByUserID($userID) {
    
        $this->db->where('user_id', $userID);
        $twitterAccounts = $this->db->get($this->tableName);

        if($twitterAccounts->num_rows() == 0) {
            return false;    
        }

        return $twitterAccounts->result_array();
    }

    /****
    *
    *
    *
    */
    public function addAccount($userID, $credentials) {
   
        $data = array(
            'user_id'   => $userID,
            'credentials' => json_encode($credentials),
        );

        $this->db->insert($this->tableName, $data); 
        return $this->db->insert_id();
    }
  
    /****
    *
    *
    *
    */
    public function oauth_accessToken($params) {
        return $this->codebirdDriver->oauth_accessToken($params);
    }
    
    /****
    *
    *
    *
    */
    public function oauth_requestToken($params) {
        return $this->codebirdDriver->oauth_requestToken($params);
    }

    /****
    *
    *
    *
    */
    public function oauth_authorize() {
        return $this->codebirdDriver->oauth_authorize();
    }

    /****
    *
    *
    *
    */
    public function setToken($oauthToken, $oauthTokenSecret) {
        return $this->codebirdDriver->setToken($oauthToken, $oauthTokenSecret);
    }

    /****
    *
    *
    *
    */
    public function users_show($params) {
        return $this->codebirdDriver->users_show($params);
    }

    /****
    *
    *
    *
    */
    public function statuses_update($params) {
        return $this->codebirdDriver->statuses_update($params);
    }
    
    /****
    *
    *
    *
    */
    public function statuses_userTimeline($params) {
        $data = $this->codebirdDriver->statuses_userTimeline($params);
        unset($data->httpstatus);
        return $data;
    }
    
    /****
    *
    *
    *
    */
    public function statuses_homeTimeline($params) {
        $data = $this->codebirdDriver->statuses_homeTimeline($params);
        unset($data->httpstatus);
        return $data;
    }

    /****
    *
    *
    *
    */
    public function statuses_mentionsTimeline($params) {
        $data = $this->codebirdDriver->statuses_mentionsTimeline($params);
        unset($data->httpstatus);
        return $data;
    }

    /****
    *
    *
    *
    */
    public function followers_list($params = null) {
        $data = $this->codebirdDriver->followers_list($params);
        unset($data->httpstatus);
        return $data;
    }
}
