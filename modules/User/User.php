<?php 

require_once dirname(__FILE__).'/../../includes/ClassCreation.php';

Class User {

	public $user;
	public $params;
	public static $addUserMandatoryData = array(
			'first_name',
			'user_type',
			'email'
		);

	public static $getUserMandatoryData = array(
			'user_id'
		);

	public static $editUserMandatoryData = array(
			'user_id'
		);


	public function __construct(){
		$this->params 	= ClassCreation::getRawPostData();
		$classToCall = get_class($this);
		$this->user = ClassCreation::Factory($classToCall,$this->params);
	}

	/**
	 * This method is used to add the new user to the database
	 */
	public function addUser(){
		$response = array();
		$this->_validateData('add');
		$result = $this->user->addUser();
		if(!empty($result) && $result != false){
			$response['user_id'] = $result;
			$response['msg'] = "user id inserted successfully";
		}
		return $response;
	}

	/**
	 * This method is used to get the info for the user
	 * @return array containing the user information
	 */
	public function getUser(){
		$response = array();
		$this->_validateData('get');
		$result = $this->user->getUser();
		if(!empty($result) && $result != false){
			foreach($result as $user_key => $user_value){
				$response[$user_key] = $user_value;
			}
		}
		return $response;
	}

	/**
	 * This method is used to edit the user for the updation
	 * @return array contaning the message for the updation
	 */
	public function editUser(){
		$response = array();
		$this->_validateData('edit');
		$result = $this->user->editUser();
		if(!empty($result) && $result == 1){
			$response['msg'] = "user id updated successfully";	
		}else{
			$response['msg'] = "nothing to be updated";	
		}
		return $response;
	}

	/**
	 * This method is used to validate the params for the different modes
	 * @param  string containing the mode for the current params
	 * @return null checks for the validity for the current mode
	 */
	private function _validateData($method){
		switch ($method){
			case 'add':
			$this->_checkForParams(self::$addUserMandatoryData , 'Add');
			break;	

			case 'edit':
			$this->_checkForParams(self::$editUserMandatoryData , 'Edit');
			break;				

			case 'get':
			$this->_checkForParams(self::$getUserMandatoryData , 'Get');
			break;
		}
	}

	/**
	 * Checks within the loop for the missing params and throws the exception for the same
	 * @param  array $require_params [description]
	 * @param  string $mode           [description]
	 * @return null                 [description]
	 */
	private function _checkForParams($require_params,$mode){
		$message = "";
		$error = 0;
		foreach($require_params as $key ){
			if(!isset($this->params[$key]) || empty($this->params[$key])){
				$message = "Missing the mandatory field ".$key." for the ".$mode ." User";
				$error = 1;
				break;
			}
		}
		if($error){
			throw new Exception($message,rand());
		}
	} 

}

?>