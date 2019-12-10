<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Delivery Info</title>
    <link rel="stylesheet" href="../CSS/FormatDeliveyInfo.css">
  </head>
  
  <body>
    <?php
	  session_start();	  	  
	  
	  if(isset($_POST['btn_log'])){	
	     $_SESSION["delivery_details"]=array("no"=>$_POST["txt_no"],"street"=>$_POST["txt_street"],"city"=>$_POST["txt_city"],"country"=>$_POST["txt_country"]);			  
		  header('location:Chekout.php'); 
	  }  
	  
	  if(isset($_POST["btn_cancel"])){
		  header("Location:HomePage.php");
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
             <h2>Provide Delivery Info.</h2>
           </div>
           <div id="registration_form_area">
             
             <form method="post" name="registration_form">
                <div class="control"> 
                   <label for="txt_no">No:</label><br>                  
                   <input id="txt_no" name="txt_no" type="text" placeholder="Address-No" class="field" required>
                </div>
                <div class="control"> 
                   <label for="txt_street">Street:</label><br>                  
                   <input id="txt_street" name="txt_street" type="text" placeholder="Address-Street" class="field" required>
                </div> 
                <div class="control"> 
                   <label for="txt_city">City:</label> <br>                 
                   <input id="txt_city" name="txt_city" type="text" placeholder="Address-City" class="field" required>
                </div> 
                <div class="control"> 
                   <label for="txt_country">Country:</label> <br>                 
                   <input id="txt_country" name="txt_country" type="text" placeholder="Address-Country" class="field" required>
                </div>                
                <div class="form_action">
                    <button type="submit" name="btn_log" id="log_button" class="buttons">Continue</button><br>
                    <button type="submit" name="btn_cancel" id="cancel_button" class="buttons">Cancel</button>
                </div>
                                
             </form>
           </div>
        </div>
    </div>
   
  </body>
</html>