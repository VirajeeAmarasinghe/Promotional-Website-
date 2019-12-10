<?php
class CartItem
{
private $productCode;
private $qty;
private $productName;
private $price;

public function setCode($_code)
{
	$this->productCode=$_code;
	}
public function setQty($_qty)
{
	$this->qty=$_qty;
	}
public function getCode()
{
	return $this->productCode;
	}
	
public function getQty()
{
	return $this->qty;
	}
public function setName($_name)
{
	$this->productName=$_name;
	}
public function getName()
{
	return $this->productName;
	}
public function setPrice($_price)
{
	$this->price=$_price;
	}
public function getPrice()
{
	return $this->price;
	}
	
}


?>