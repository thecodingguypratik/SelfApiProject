<?php

	require_once './classes/DBOperations.php';

	class UserActionDB extends DBOperations{
		
		public function __construct(){
			parent::__construct();
		}

		/**
		 * This method is used to insert the data for the users
		 * @param  [type] $params [description]
		 * @return int containing the inserted id for the user
		 */
		public function insertUserData($params){
			 $sql = "insert into users (first_name,last_name,email,age,gender,user_type) values ('%s','%s','%s',%u,'%s','%s')";
			 $sanitisedSql = sprintf($sql,$params['first_name'],$params['last_name'],$params['email'],$params['age'],$params['gender'],$params['user_type']);
			 return $resp = $this->dbQueryInsert($sanitisedSql);
		}

		/**
		 * This method is used to get the user information
		 * @param  [type] $params [description]
		 * @return array  containing the info for the user id mentioned
		 */
		public function getUserData($params){
			$sql = "select first_name,last_name,email,age,gender,user_type from users where id = %u and status = %u";
			$sanitisedSql = sprintf($sql,$params['user_id'],1);
			return $resp = $this->dbGetRow($sanitisedSql);	
		}

		/**
		 * This method is used to edit the db data for the user 
		 * @param  array containing the value for the user id
		 * @return int containing the value for the updation
		 */
		public function editUserData($params){ // apply check for the user id should not be empty
			$sql = "update users set ";
			foreach($params as $update_key => $update_value){
				if($update_key != 'user_id'){
					$sql .= $update_key .' = "'. $update_value .'",'; 
				}
			}
			$sql = rtrim($sql, ',');
			$sql .= ' where id = %u';
			$sanitisedSql = sprintf($sql,$params['user_id']);	
			return $resp = $this->dbQueryUpdate($sanitisedSql);		
		}
	}

?>