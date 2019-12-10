<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="../CSS/FormatCheckout.css">
  </head>
  
  <body>
    <?php
	  
	  	require_once('Classes/CartItem.php'); 
		require_once('Classes/AvoidErrors.php');
		
		$err=new Errors();
	    $err->fixObject($_SESSION['cart']);  
    	  
		  session_start();
	  //calculate total amount
	  $total=0;
	  if(isset($_SESSION['cart'])){
	           $cart=$_SESSION['cart'];	
			   
	           $total=0;
			   $i=new CartItem();	
	           foreach($cart as $item){
				   $i=$item;
		             $cost=$i->getPrice()*$i->getQty();		
			         $total=$total+$cost;					
	           }	
       }
		 
	  if(isset($_POST['btn_log'])){	
	  
	     if(validation()){
			 //save cart
			 require_once('config/DBConnection.php');
			 try{
		         $conn = DBConnection::GetConnection();
		  
		         $query="INSERT INTO shopping_cart(order_date,address_no,address_street,address_city, address_country, total) VALUES (:order_date,:address_no,:address_street,:address_city,:address_country,:total)";
		  
		         $st=$conn->prepare($query);
				 
				 //get current date-time
				 date_default_timezone_set('Europe/London');
				 $currentDate=date('Y-m-d');
				 
				 $no=$_SESSION["delivery_details"]["no"];
				 $street=$_SESSION["delivery_details"]["street"];
				 $city=$_SESSION["delivery_details"]["city"];
				 $country=$_SESSION["delivery_details"]["country"];
		  
		         $st->bindvalue(":order_date",$currentDate,PDO::PARAM_STR);
		         $st->bindvalue(":address_no",$no,PDO::PARAM_STR); /*for the double PARAM type is what?*/
		         $st->bindvalue(":address_street",$street,PDO::PARAM_STR);
		         $st->bindvalue(":address_city",$city,PDO::PARAM_STR);
		         $st->bindvalue(":address_country",$country,PDO::PARAM_STR); 
		         $st->bindvalue(":total",$total,PDO::PARAM_INT);
		  
		  
		         $result=$st->execute();	
				 if($result==true){
					 echo '<script>alert("Thank U")</script>';
				 }else{
					 echo '<script>alert("Error Occurres")</script>';
				 } 
		         
	         }catch(PDOException $e){
		        echo 'Fail to connect';
		        echo $e->getMessage();	  
             }	 
			 
			 
		 }
		 
		 
	  
	     //unset sessions
		 unset($_SESSION["cart"]);
		 unset($_SESSION["delivery_details"]);
	  }  
	  
	  if(isset($_POST["btn_cancel"])){
		  header("Location:HomePage.php");
	  }
	  
	  function validation(){
	   $result=true;
	   if(empty($_POST["txt_card"])){
		   echo '<script>alert("Credit Card field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["txt_code"])){
		   echo '<script>alert("Security Code field is empty")</script>';
		   $result=false;
	   }
	   return $result;
   }
      
   ?>
    <img src="../Images/Register_background_image2.jpg" width="100%" height="auto" id="background_image">
    <div id="main_content">
        <div id="title">
           <a href="HomePage.php"><h1 id="main_title">ONE DIRECTION</h1></a>
           <a href="HomePage.php"><h1 id="sub_title">1D</h1></a>
        </div>
        <div id="registration_form" class="registration_form">
           <div class="page_header">
             <h2>Payment</h2>
           </div>
           <div id="registration_form_area">
             
             <form method="post" name="registration_form">
                <div class="control"> 
                   <label for="txt_total">Total:</label> <br>                 
                   <input id="txt_total" name="txt_total" type="text" class="field" readonly value="<?php echo $total;?>"><br>
                </div>
                <div class="control"> 
                   <label for="txt_card">Credit Card No:</label><br>                  
                   <input id="txt_card" name="txt_card" type="text" placeholder="Credit Card No" class="field" required><br>
                </div> 
                <div class="control"> 
                   <label for="txt_code">Security Code:</label><br>                  
                   <input id="txt_code" name="txt_code" type="text" placeholder="Security Code" class="field" required><br>
                </div> 
                                
                <div class="form_action">
                    <button type="submit" name="btn_log" id="log_button" class="buttons">Pay</button><br>
                    <button type="submit" name="btn_cancel" id="cancel_button" class="buttons">Cancel</button>
                </div>
                                
             </form>
           </div>
        </div>
    </div>
   
  </body>
</html>