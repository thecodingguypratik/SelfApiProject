<?php

require_once './includes/connection.php';

	class DBOperations{

		public $db_connection;

		public function __construct(){
			$this->db_connection = new DBConnection(); // for the mysql connection
		}
		
		public function dbGetRow($sql){
			$result = $this->db_connection->conn->query($sql);
			if ($result->num_rows > 0) {
			    return $result->fetch_assoc();
			}
			return false;
		}


		public function dbQueryInsert($sql){
			if ($this->db_connection->conn->query($sql) === TRUE) {
			   return $this->db_connection->conn->insert_id; // inserting the primary key for the insertion in the database
			} 
			return false;
		}

		public function dbQueryUpdate($sql){
			if ($this->db_connection->conn->query($sql) === TRUE) {
			   return  mysqli_affected_rows($this->db_connection->conn);die;
			} 
			return false;
		}

	}

?>