<?php 

require_once dirname(__FILE__).'/../../includes/ClassCreation.php';

Class Product {

	public $product;
	public $params;
	public static $addProductMandatoryData = array(
			'product_name',
			'product_category',
			'merchant_id',
			'price',
			'product_image'
		);

	public static $getProductMandatoryData = array(
			'product_id'
		);

	public static $editProductMandatoryData = array(
			'product_id'
		);
	public static $deleteProductMandatoryData = array(
			'product_id',
			'merchant_id'
		);


	public function __construct(){
		$this->params 	= ClassCreation::getRawPostData();
		$classToCall = get_class($this);
		$this->product = ClassCreation::Factory($classToCall,$this->params);
	}

	/**
	 * This method is used to add the new product to the database
	 */
	public function addProduct(){
		$response = array();
		$this->_validateData('add');
		$result = $this->product->addProduct();
		if(!empty($result) && $result != false){
			$response['product_id'] = $result;
			$response['msg'] = "product created successfully";
		}
		return $response;
	}

	/**
	 * This method is used to get the info for the product
	 * @return array containing the product information
	 */
	public function getProduct(){
		$response = array();
		$this->_validateData('get');
		$result = $this->product->getProduct();
		if(!empty($result) && $result != false){
			foreach($result as $product_key => $product_value){
				$response[$product_key] = $product_value;
			}
		}
		return $response;
	}

	/**
	 * This method is used to edit the Product Info
	 * @return array contaning the message for the updation
	 */
	public function editProduct(){
		$response = array();
		$this->_validateData('edit');
		$result = $this->product->editProduct();
		if(!empty($result) && $result == 1){
			$response['msg'] = "product info updated successfully";	
		}else{
			$response['msg'] = "nothing to be updated";	
		}
		return $response;
	}

	public function deleteProduct(){
		$response = array();
		$this->_validateData('delete');
		$result = $this->product->deleteProduct();
		if(!empty($result) && $result == 1){
			$response['msg'] = "product info deleted successfully";	
		}else{
			$response['msg'] = "nothing to be deleted";	
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
			$this->_checkForParams(self::$addProductMandatoryData , 'Add');
			break;	

			case 'edit':
			$this->_checkForParams(self::$editProductMandatoryData , 'Edit');
			break;				

			case 'get':
			$this->_checkForParams(self::$getProductMandatoryData , 'Get');
			break;

			case 'delete':
			$this->_checkForParams(self::$deleteProductMandatoryData , 'Delete');
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
				$message = "Missing the mandatory field ".$key." for the ".$mode ." Product";
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