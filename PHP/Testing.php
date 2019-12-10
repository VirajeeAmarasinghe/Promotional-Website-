<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
   require_once('Classes/Product.php');
   require_once('Classes/CartItem.php');
   require_once('config/config.php');
   
   $p1=new Product();
   $result = $p1->GetProducts();
   
   echo '<form action="" method="post" enctype="multipart/form-data" name="form1">';
   
   $count=0;
   
   foreach($result as $item){
	   $p1 = $item;
	   
	   echo '<div class="product_section">';
	   echo '<div class="product_list">';
	   echo '<div class="product">';
	   echo '<img src="../Images/Official Store/"'.$p1->getProductImage().'" alt="'.$p1->getProductImage().'">';
	   echo '<input type="hidden" name="code[]" value="'.$p1->getProductCode().'" >';
	   echo '<label>'.$p1->getProductName().'</label><br>'; 
	   echo '<input type="hidden" name="pname[]" value="'.$p1->getProductName().'" >';
	   echo '<label> $'.$p1->getProductPrice().'</label><br>';
	   echo '<input type="hidden" name="price[]" value="'.$p1->getProductPrice().'" >';
	   echo '<label>Quantity: </label><br>';
	   echo '<input type="number" name="qty[]" id="txtQty">';
	   echo '<input type="hidden" name="qty_in_stock[]" value="'.$p1->getQuantity().'" >';
	   echo '<button type="submit" name="view" value="'.$p1->getProductCode().'">View more</button><br>';	
	   echo '<button type="submit" name="buy" value="'.$count.'">Buy now</button>';
	   echo '</div></div></div>';
	   $count++;
   }
   echo '</form>';
 ?>   
</body>
</html>