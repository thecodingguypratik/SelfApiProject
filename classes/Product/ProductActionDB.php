<?php
	
	require_once './classes/DBOperations.php';

	class ProductActionDB extends DBOperations{
		
		public function __construct(){
			parent::__construct();
		}

		/**
		 * This method is used to insert the data for the Product
		 * @param  [type] $params [description]
		 * @return int containing the inserted id for the product
		 */
		public function insertProductData($params){
			
			$sql = "insert into products (product_name,product_category,merchant_id,price,product_image) values ('%s',%u,%u,'%s','%s')";
			$sanitisedSql = sprintf($sql,$params['product_name'],$params['product_category'],$params['merchant_id'],$params['price'],$params['product_image']);
			return $resp = $this->dbQueryInsert($sanitisedSql);
		}

		/**
		 * This method is used to get the product information
		 * @param  [type] $params [description]
		 * @return array  containing the info for the product id mentioned
		 */
		public function getProductData($params){
			$sql = "select product_name,product_category,merchant_id,price,product_image from products where product_id = %u and status = %u";
			$sanitisedSql = sprintf($sql,$params['product_id'],1);
			return $resp = $this->dbGetRow($sanitisedSql);	
		}

		/**
		 * This method is used to edit the db data for the product
		 * @param  array containing the value for the product id
		 * @return int containing the value for the updation
		 */
		public function editProductData($params){ 
			$sql = "update products set ";
			foreach($params as $update_key => $update_value){
				if($update_key != 'product_id'){
					$sql .= $update_key .' = "'. $update_value .'",'; 
				}
			}
			$sql = rtrim($sql, ',');
			$sql .= ' where product_id = %u';
			$sanitisedSql = sprintf($sql,$params['product_id']);	
			return $resp = $this->dbQueryUpdate($sanitisedSql);		
		}

		public function deleteProductData($params){
			$sql = 'update products set status = 0 where product_id = %u and merchant_id = %u';
			$sanitisedSql = sprintf($sql,$params['product_id'],$params['merchant_id']);	
			return $resp = $this->dbQueryUpdate($sanitisedSql);			
		}
	}

?>