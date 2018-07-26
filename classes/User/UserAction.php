<?php

require_once 'UserActionDB.php';

class UserAction {

	public $params;
	public $userDBObj;

	public function __construct($params){
		$this->userDBObj = new UserActionDB();
		$this->params = $params;	
	}

	public function addUser(){
		$result = false;
		
		if(empty($this->params['user_id']) && !empty($this->params['user_type']) && ($this->params['user_type'] == "C" || $this->params['user_type'] == "M")){
				$result = $this->userDBObj->insertUserData($this->params);
		}
		return $result;
	}

	public function getUser(){
		$result = false;
		if(!empty($this->params['user_id'])){
			$result = $this->userDBObj->getUserData($this->params);
		}
		return $result;
	}

	public function editUser(){
		$result = false;
		if(!empty($this->params['user_id'])){
			$result = $this->userDBObj->editUserData($this->params);
		}
		return $result;
	}

}

?>