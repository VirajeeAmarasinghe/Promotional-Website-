<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Product Description</title>
    <link rel="stylesheet" href="../CSS/FormatProductDescription.css">
  </head>
  
    
  <body>
  
    <div id="top_stripe">
    <div id="homePage">
      <a href="HomePage.php"><img src="../Images/home.png" alt="Home button" width="40" height="40"></a>
    </div>
     <div id="search_box_form_div">
        <form method="post" name="search_box_form" id="search_box_form">
          <!--style="border:none->"to remove the border/outline around the text box--> 
          <input type="text" name="search_box" id="search_box">        
        </form>
      </div> 
      <div id="registration_nav">
        <ul>
          <li><a href="RegistrationForm.php">REGISTER</a></li>
          <?php
               require_once('Classes/AvoidErrors.php');
	           require_once('Classes/Product.php');
	           require_once('config/config.php');
	           require_once('Classes/CartItem.php');	

		  ?>
          <?php session_start();if(isset($_SESSION["user_details"])){
		             echo '<li><a href="?link=logoutLink">LOG OUT</a></li>';
			     }else if(!isset($_SESSION["user_details"])){
					 echo '<li><a href="LoginForm.php">LOGIN</a></li>';
				 }
		  ?>
          
        </ul>
      </div>
    </div>
    
    <?php if(isset($_GET["link"])){
	   unset($_SESSION["user_details"]);
	   header("Location:HomePage.php");
   }?>
    
    
    <div id="second_stripe">
      <a href="HomePage.php">
        <h1 id="singer_fname">ONE</h1>
        <h1 id="singer_lname">DIRECTION</h1>
      </a>
    </div>
    
    <nav class="main">
    <div id="Nav">
        <ul>
        <?php echo '<form action="" method="post" enctype="multipart/form-data" name="form2">';?>
           <li><a href="Help.php">HELP</a></li>
           <li><a href=""><?php echo '<button type="submit" name="viewCart" value="">VIEW SHOPPING CART</button>';?></a></li>
           <li><a href=""><?php echo '<button type="submit" name="checkout" value="">CHECKOUT</button>';?></a></li>           
        </ul>
        <?php echo '</form>';?>
        </div>
    </nav>  
    
    
    <div id="top_banner">
      <img src="../Images/Official Store/BannerImage.jpg" alt="top_banner_official_store" width="100%">
    </div>
    
    <?php 
	  
	  	  
	  //to avoid object incomplete error
	  $err=new Errors();
	  $err->fixObject($_SESSION['cart']);  
	   
	    
	  
	  //redirecting to previous pages
	  if(isset($_POST["go_back"])){
		  $pageName=$_SESSION["page_name"];
		  if($pageName=="Featured"){
			  header('location:StoreOneDirection.php');
		  }
		  if($pageName=="Exclusive"){
			  header('location:Exclusive.php');
		  }
		  if($pageName=="Albums"){
			  header('location:Albums.php');
		  }
		  if($pageName=="DVD"){
			  header('location:DVD.php');
		  }
		  if($pageName=="Other"){
			  header('location:Other.php');
		  }
	  }
	  
	  if(isset($_POST["buy"])){	 
		  if(!isset($_SESSION['cart'])){		  
			  $myItem=array();
			  $_SESSION['cart']=$myItem;		 		  
		  }
	      $myItem=$_SESSION['cart'];
	      
	  if(isset($_POST['qty'])){
		  $index=0;
		  $found=false;		 
		  
		  foreach($myItem as $citem){
			  
			  
			  if($citem->getCode()==$_POST["buy"]){
				  
				  $cQty=$citem->getQty();
				  $newQty=$cQty+$_POST['qty'];			  
				  
				  if($newQty<=$_POST["qty_in_stock"]){
					  $myItem[$index]->setQty($newQty);	
					  echo '<div class="message_box">Updated The Cart</div>';
					  $found=true;				 
				  }else{
					  echo '<div class="message_box">Sorry,Available Only:'.$_POST["qty_in_stock"].' In Stock.</div>';  $found=true;
				  }		  
				  
			  }
		      $index++;
		  }
		  if(!$found){		 
			 
			 
			 if($_POST["qty"]<=$_POST["qty_in_stock"]){ 
				echo '<div class="message_box">Added To The Cart</div>';

				$item = new CartItem();
				
				$item->setCode($_POST["code"]);
				$item->setQty($_POST["qty"]);
				$item->setName($_POST["pname"]);
				$item->setPrice($_POST["price"]);
				
				array_push($myItem,$item);
				
			 }else{ 				 
				 echo '<div class="message_box">Sorry,Available Only:'.$_POST["qty_in_stock"].'</div>';
		     }
		 }
		  $_SESSION['cart']=$myItem;		 
		 
	  }
	}
	  
	  if( isset( $_SESSION["view"])){
		  $p1=new Product();
		  $p1->setProductCode($_SESSION["view"]);
		  $p2=$p1->GetProduct();
		  
		  echo '<form action="" method="post" enctype="multipart/form-data" name="form1">';
		  
		  echo '<div class="product">';
		  echo '<div class="image">';
		  //ammend this code according to saved images' extension
		  $source="../Images/Official Store/".$p2->getProductImage(); 
		   
		  echo '<img src="'.$source.'" alt="'.$p2->getProductImage().'"></div>';
		  echo '<input type="hidden" name="code" value="'.$p2->getProductCode().'" >';
		  echo '<div class="text">';
		  echo '<label class="pro_name">'.$p2->getProductName().'</label><br>'; 
		  echo '<input type="hidden" name="pname" value="'.$p2->getProductName().'" >';
		  echo '<label class="pro_description">'.$p2->getProductDescription().'</label><br>'; 
		  echo '<label class="price">Price: $'.$p2->getProductPrice().'</label><br>';
		  echo '<input type="hidden" name="price" value="'.$p2->getProductPrice().'" >';		  
		  echo '<label class="pro_stock">Quantity In Stock: '.$p2->getQuantity().'</label><br>'; 
		  echo '<input type="hidden" name="qty_in_stock" value="'.$p2->getQuantity().'" >';
		  echo '<label class="quantityEnter">Quantity: </label>';
		  echo '<input type="number" name="qty" id="txtQty" value="1"><br>';
		  echo '<div class="buttons">';		  	
		  echo '<div class="buy">';
		  echo '<button type="submit" name="buy" value="'.$p2->getProductCode().'" class="buy">Buy now</button></div>';
		  echo '<div class="go" id="go">';
		  echo '<button type="submit" name="go_back" value="'.$p2->getProductCode().'" class="go">Go Back</button><br></div>';//
		  echo '</div></div></div></div>';
		  echo '</form>';
	  }else{
		  header('location:StoreOneDirection.php');
	  }

?>

    
    <div class="privacy_policy_bar">
      <div class="privacy_policy_bar_include">
        <ul>
          <li>
            <a href="http://www.myplay.com/direct/terms-conditions?origin=desktop&permalink=one-direction" class="terms">Terms & Conditions</a>
          </li> 
          <li>
            <a href="http://www.myplay.com/direct/privacy-policy?origin=desktop&permalink=one-direction">Privacy Policy</a>
          </li> 
          <li>
            <a href="http://www.myplay.com/direct/cookie-policy?origin=desktop&permalink=one-direction">Cookie Policy</a>
          </li> 
          <li>
            <a href="Help.php">Help</a>
          </li>        
        </ul>
        <p>Copyright 2016 MyPlay Direct</p>
      </div>
    </div> 
   
      
  </body>
</html>