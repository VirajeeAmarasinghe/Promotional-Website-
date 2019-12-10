
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Official One Direction Store-AlBums</title>
    <link rel="stylesheet" href="../CSS/FormatOneDirectionStore.css">
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
              require_once('Classes/CartItem.php');
              require_once('config/config.php');
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
    
    
    <nav class="main_subnavi">
     <div id="Navig_sub">
        <ul>
           <li><a href="StoreOneDirection.php">ALL</a></li>
           <li><a href="Exclusive.php">EXCLUSIVE</a></li>
           <li><a href="Albums.php" class="first_a">ALBUMS</a></li>
           <li><a href="DVD.php">DVDS</a></li>
           <li><a href="Other.php">OTHER</a></li>           
        </ul>
      </div>
    </nav>
    
    <div id="top_banner">
      <img src="../Images/Official Store/BannerImage.jpg" alt="top_banner_official_store" width="100%">
    </div>
    
    
    <nav class="main">
    <div id="Nav">
        <ul>
        <?php echo '<form action="" method="post" enctype="multipart/form-data" name="form2">';?>
           <li><a href="Help.php">HELP</a></li>
           <li><a href=""><?php echo '<button type="submit" name="viewCart" value="">VIEW SHOPPING CART</button>';?></a></li>
           <li><a href=""><?php echo '<button type="submit" name="checkout" value="">CHECKOUT</button>';?></a></li><!--have to do -->           
        </ul>
        <?php echo '</form>';?>
        </div>
    </nav>
    
 <?php 
   
   
   //to avoid object incomplete error
	  $err=new Errors();
	  $err->fixObject($_SESSION['cart']);  
   
   
   if(isset($_POST['view'])){	
	  $_SESSION["view"]= $_POST["view"];
	  header('location:All_Product_1_Description.php');
   }if(isset($_POST["buy"])){	 
	  if(!isset($_SESSION['cart'])){		  
		  $myItem=array();
		  $_SESSION['cart']=$myItem;		 		  
	  }
	  $myItem=$_SESSION['cart'];
	  
	  if(isset($_POST['qty'])){
		  $index=0;
		  $found=false;
		  $item=new CartItem();
		  foreach($myItem as $citem){
			  $item=$citem;
			  
			  if($item->getCode()==$_POST["code"][$_POST["buy"]]){
				  $cQty=$item->getQty();
				  $newQty=$cQty+$_POST['qty'][$_POST["buy"]];
				  if($newQty<=$_POST["qty_in_stock"][$_POST["buy"]]){
					  $myItem[$index]->setQty($newQty);	
					  echo '<div class="message_box">Updated The Cart</div>';

					  $found=true;				 
				  }else{
					  echo '<div class="message_box">Sorry,Available Only:'.$_POST["qty_in_stock"][$_POST["buy"]].' In Stock.</div>';  $found=true;
				  }				  
				  
			  }
				  $index++;
		  }
		  if(!$found){
			 
			 if($_POST["qty"][$_POST["buy"]]<=$_POST["qty_in_stock"][$_POST["buy"]]){ 
				echo '<div class="message_box">Added To The Cart</div>';

				$item = new CartItem();
				
				$item->setCode($_POST["code"][$_POST["buy"]]);
				$item->setQty($_POST['qty'][$_POST["buy"]]);
				$item->setName($_POST["pname"][$_POST["buy"]]);
				$item->setPrice($_POST['price'][$_POST["buy"]]);
				
				array_push($myItem,$item);
				
			 }else{ 				 
				 echo '<div class="message_box">Sorry,Available Only:'.$_POST["qty_in_stock"][$_POST["buy"]].'</div>';
		     }
		 }
		  $_SESSION['cart']=$myItem;		 
		 
	  }
	}
	  
	if(isset($_POST["viewCart"])){   
       header('location:myCart.php');
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
	
   $_SESSION["page_name"]="Albums";
   $p1=new Product();
   $result = $p1->GetProducts();  
   
   
   $count=0;
   echo '<form action="" method="post" enctype="multipart/form-data" name="form1">';
   foreach($result as $item){
	   $p1 = $item;
	   
	   
	   echo '<div class="product">';
	   echo '<div class="image">';
	   $source="../Images/Official Store/".$p1->getProductImage(); //ammend this code according to saved images' extension
	   
	   echo '<img src="'.$source.'" alt="'.$p1->getProductImage().'"></div>';
	   echo '<input type="hidden" name="code[]" value="'.$p1->getProductCode().'" >';
	   echo '<div class="text">';
	   echo '<label class="pro_name">'.$p1->getProductName().'</label><br>'; 
	   echo '<input type="hidden" name="pname[]" value="'.$p1->getProductName().'" >';
	   echo '<label class="price"> $'.$p1->getProductPrice().'</label><br>';
	   echo '<input type="hidden" name="price[]" value="'.$p1->getProductPrice().'" >';
	   echo '<label>Quantity: </label>';
	   echo '<input type="number" name="qty[]" id="txtQty" value="1"><br>';
	   echo '<input type="hidden" name="qty_in_stock[]" value="'.$p1->getQuantity().'" >';
	   echo '<div class="buttons">';
	   echo '<div class="view">';
	   echo '<button type="submit" name="view" value="'.$p1->getProductCode().'">View more</button><br></div>';	
	   echo '<div class="buy">';
	   echo '<button type="submit" name="buy" value="'.$count.'" id="buy">Buy now</button></div>';
	   echo '</div></div></div>';
	   $count++;
   }
   echo '</form>';
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