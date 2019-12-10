<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Cart</title>
<link rel="stylesheet" href="../CSS/newcss.css">
</head>

<body>

<?php
 require_once('Classes/Product.php');
   require_once('Classes/CartItem.php');
   require_once('config/config.php');
   require_once('config/DBConnection.php');
   
   $class="invisible";

session_start();
if(isset($_POST['update']))
{
	$cart=$_SESSION['cart'];
	$index=$_POST['update'];
	$cart[$index]->setQty($_POST['qty'][$index]);
	$_SESSION['cart']=$cart;
	
}
else if(isset($_POST['remove']))
{
	$cart=$_SESSION['cart'];
	$index=$_POST['remove'];
	array_splice($cart,$index,1); 
	
	$_SESSION['cart']=$cart;
}

if(isset($_POST["btn_empty"])){
	if(isset($_SESSION['cart'])){
		unset($_SESSION['cart']);
	    $class="message";
	}		
}

if(isset($_POST["checkout"])){
		if(isset($_SESSION['cart'])){
			if(isset($_SESSION["user_details"])){
			   header('location:DeliveryInfo.php');
			}else{
				header('location:LoginForm.php');
			}
		}else{
			echo '<script>alert("First do shopping")</script>';
		}
	}


echo '<form action="" method="post" enctype="multipart/form-data" name="form1">';
echo '<div class="navigation">';
echo '<ul>';
echo '<li><a href="HomePage.php">Home</a></li>';
echo '<li><a href="#">Products</a>
         <ul class="dropdown">
		    <li><a href="StoreOneDirection.php">All</a></li>
            <li><a href="Exclusive.php">Exclusive</a></li>
            <li><a href="Albums.php">Albums</a></li>
			<li><a href="DVD.php">DVDS</a></li>
			<li><a href="Other.php">Other</a></li>
		 </ul>
     </li>';
echo '<li><input type="text" name="search_box" id="search_box" value="Search Product Here"></li>';
echo '</ul>';
echo '</div>';
echo '<div class="myCartTitle">';
echo '<div class="title">';
echo '<h1>MY CART</h1>';
echo '</div>';
echo '</div>';
echo '<div class="empty_button">';
echo '<p class="'.$class.'">Cart Is Emptied</p>';
echo '<input type="submit" name="btn_empty" value="Empty Cart" class="btn_empty">';
echo '</div>';

if(isset($_SESSION['cart']))
{
	$cart=$_SESSION['cart'];
	echo '<div class="cart_table">';
	echo'<table>';
	echo'<tr><th>Product Name</th><th>Unit Price(Rs.)</th><th>Quantity</th><th>Sub Total</th><th>Action</th></tr>';
	$total=0;
	$count=0;
	foreach($cart as $item)
	{
		$cost=$item->getPrice()*$item->getQty();
		echo'<td>'.$item->getName().'</td>
			<td>'.$item->getPrice().'</td>
			<td> <input type="number" name="qty[]" value="'.$item->getQty().'" class="txteSmall">
			<button type="submit" name="update" value="'.$count.'" class="btneSmall" id="update">Update</button>
			 </td>
			<td>'.$cost.' </td>	
			<td> <button type="submit" name="remove" value="'.$count.'" class="btneSmall" id="remove">Remove From Cart</button> </td>	
			</tr>';
			$total=$total+$cost;
			$count++;		
	}
	echo'<tr><td></td><td></td><td>Total</td><td> '.$total.'</td><td><button type="submit" name="checkout" value="" class="btneSmall" id="checkout">CHECKOUT</button></td>'; /*have to edit */
   echo'</table>';
   echo '</div>';
}


echo '</form>';
?>

</body>
</html>