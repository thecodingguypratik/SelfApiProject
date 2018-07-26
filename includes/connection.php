<?php

class DBConnection {
	
	public $db_name;
	public $db_username;
	public $db_password;
	public $db_host;

	public function __construct(){
		$this->db_name = "wydr";
		$this->db_username = "root";
		$this->db_password = "shopclues";
		$this->db_host = "localhost";
		return $this->_setConnection();
	}

	private function _setConnection(){
		return $this->conn=new mysqli($this->db_host,$this->db_username,$this->db_password,$this->db_name);
	}

}


?>