<?php

require_once 'ProductActionDB.php';

class ProductAction {

	public $params;
	public $prodDBObj;

	public function __construct($params){
		$this->prodDBObj = new ProductActionDB();
		$this->params = $params;	
	}

	public function addProduct(){
		$result = false;
		if(empty($this->params['product_id']) ){
			$result = $this->prodDBObj->insertProductData($this->params);
		}
		return $result;
	}

	public function getProduct(){
		$result = false;
		if(!empty($this->params['product_id'])){
			$result = $this->prodDBObj->getProductData($this->params);
		}
		return $result;
	}

	public function editProduct(){
		$result = false;
		if(!empty($this->params['product_id'])){
			$result = $this->prodDBObj->editProductData($this->params);
		}
		return $result;
	}

	public function deleteProduct(){
		$result = false;
		if(!empty($this->params['product_id']) && !empty($this->params['merchant_id'])){
			$result = $this->prodDBObj->deleteProductData($this->params);
		}
		return $result;	
	}

}

?>