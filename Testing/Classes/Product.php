<?php
  require_once('config/DBConnection.php');
  
  class Product{
	  
	private $productCode;
	private $productName;
	private $price;	 
	private $description;
	private $imageName;
	private $qty;
	private $cate;
		
	
	//set and get methods
	
	public function setProductCode($_productCode)
	{
		$this->productCode = $_productCode;
	}	
	public function getProductCode()
	{
		return $this->productCode ;
	}
	public function setProductName($_productName)
	{
		$this->productName = $_productName;
	}	
	public function getProductName()
	{
		return $this->productName ;
	}
	public function setProductPrice($_productPrice)
	{
		$this->price = $_productPrice;
	}
	public function getProductPrice()
	{
		return $this->price ;
	}
	public function setProductDescription($_description)
	{
		$this->description = $_description;
	}
	public function getProductDescription()
	{
		return $this->description ;
	}
	public function setProductImage($_image)
	{
		$this->imageName=$_image;
	}
	public function getProductImage()
	{
		return $this->imageName;
	}
	public function setQuantity($qty){
		$this->qty=$qty;
	}
	public function getQuantity(){
		return $this->qty;
	}
	public function setCategory($cate){
		$this->cate=$cate;
	}
	public function getCategory(){
		return $this->cate;
	}
	  
		//Data methods
		
		//methods for inserting new product details into the database
		
	public function Add(){	
	  try{
		  $conn = DBConnect::GetConnection();
		  
		  $query="INSERT INTO product(product_name,unit_price,image_name,description,category,quantity_in_stock) VALUES 					(:name,:uPrice,:imageName,:des,:cate:,qty)";
		  
		  $st=$conn->prepare($query);
		  
		  $st->bindvalue(":name",$this->productName,PDO::PARAM_STR);
		  $st->bindvalue(":uPrice",$this->price,PDO::PARAM_INT); /*for the double PARAM type is what?*/
		  $st->bindvalue(":imageName",$this->imageName,PDO::PARAM_STR);
		  $st->bindvalue(":des",$this->description,PDO::PARAM_STR);
		  $st->bindvalue(":cate",$this->cate,PDO::PARAM_STR); //category id->foreign key
		  $st->bindvalue(":qty",$this->qty,PDO::PARAM_INT);
		  
		  
		  $st->execute();
		  echo 'Done';
		  
	  }
	  catch(PDOException $e){
		  echo 'Fail to connect';
		  echo $e->getMessage();	  
      }
  }
	
	
	
	public function GetProducts(){	
	  $page_name=$_SESSION["page_name"];
	  try{
		  $conn = DBConnection::GetConnection();	
		  $myquery= "SELECT product_id,product_name,unit_price,image_name,description,category,quantity_in_stock FROM product where category like '%{$page_name}%'";
		  $result= $conn->query($myquery);
		  $products=array();
		  foreach($result as $item)
		  {
			  $p1= new Product();
			  $p1->productCode =$item["product_id"];
			  $p1->productName =$item["product_name"];
			  $p1->price =$item["unit_price"];
			  $p1->imageName=$item["image_name"];			  
			  $p1->description =$item["description"];
			  $p1->cate=$item["category"];
			  $p1->qty=$item["quantity_in_stock"];
			  array_push($products,$p1);			  			  
		  }
		  $conn =null;//To close the connection 
		  return $products;
	  }catch(PDOException $e){
		  echo 'Fail to connect';
		  echo $e->getMessage();
	  }	
		  
  }
	  
	public function GetProduct(){
	
	try
	{
		$conn = DBConnection::GetConnection();
		$myquery= "SELECT product_id,product_name,unit_price,image_name,description,category,quantity_in_stock FROM product where product_id='".$this->productCode."' ";
		$result= $conn->query($myquery);
		
		$p1= new Product();
		foreach($result as $item){
						
			  $p1->productCode =$item["product_id"];
			  $p1->productName =$item["product_name"];
			  $p1->price =$item["unit_price"];
			  $p1->imageName=$item["image_name"];			  
			  $p1->description =$item["description"];
			  $p1->cate=$item["category"];
			  $p1->qty=$item["quantity_in_stock"];			
			
		}
		$conn =null;//To close the connection 
		return $p1;
	}
	catch(PDOException $e)
	{
		echo 'Fail to connect';
		echo $e->getMessage();
	}	
		
	}	
	
	}
  
  ?>
  
