<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../CSS/FormatResetPassword.css">
  </head>
  
  <body>
    <?php
       require_once('Classes/Member.php');
	  
       $message="";
	   $message_div="hide_div";
	   
	   if(isset($_POST['btn_reset'])){		   		  
		  $resturendValue=validation();
		  if($resturendValue){			  
			  $m=new Member();
			  $result1=$m->checkUserAccount($_POST["username"]);
			  if($result1==true){				  
				  $email=$m->getEmailAddressAccordingToUsername($_POST["username"]);
				  if($email==$_POST["email"]){
					  //password reseting goes here					  
					  $password=$_POST["password"];
					  $m->setPassword($password);					 
					  $m->setUserName($_POST["username"]);
					  $m->setEmail($_POST["email"]);
					  $result2=$m->changePassword();
					  if($result2==true){
						  global $message_div;
			              global $message;	
			              $message_div="visible_div";			 
			              $message ="Password Changed Successfully.";
					  }
				  }else{
					  global $message_div;
			          global $message;	
			          $message_div="visible_div";			 
			          $message ="Entered email address does not match with the profile email.";
				  }
			  }else{
				  global $message_div;
			      global $message;	
			      $message_div="visible_div";			 
			      $message ="There is no user account on entered username.";
			  }
		  }
	  }
	   
	   if(isset($_POST["btn_cancel"])){
		  header("Location:HomePage.php");
	   }
	   
	   	   
	   function validation(){
		  $result=true;
		  /* Form Required Field Validation */  
		  
         		  
		   if(empty($_POST["email"])) {
			   global $message_div;
			   global $message;	
			   $message_div="visible_div";			 
			   $message ="Email field is required";
			   $result=false; 			  
		   }else if(empty($_POST["username"])) {
			   global $message_div;
			   global $message;	
			   $message_div="visible_div";			 
			   $message ="Username field is required";
			   $result=false; 			   
		   }else if(empty($_POST["password"])){
			   global $message_div;
			   global $message;	
			   $message_div="visible_div";			 
			   $message ="Password field is required";
			   $result=false; 			   
		   }else if(empty($_POST["confirm_pass"])) {
			   global $message_div;
			   global $message;	
			   $message_div="visible_div";			 
			   $message ="Confirm Password field is required";
			   $result=false; 			   
		   }
		   
		   //establishing password policy
		   if($result==true){
			   $password=$_POST["password"];
			   if(strlen($password)<8){
				   global $message_div;
			       global $message;	
				   $message_div="visible_div";			 
			       $message ="Password must contain more than 8 characters";
			       $result=false;	
			   }else if(preg_match('/[A-Z]/',$password)!=1){ //preg_match() returns 1 if the pattern matches given subject, 0 if it does not, or FALSE if an error occurred.
				   global $message_div;
			       global $message;	
				   $message_div="visible_div";			 
			       $message ="Password must contain Atleast One Uppercase letter";
			       $result=false;
			   }else if(preg_match('/[a-z]/',$password)!=1){ 
				   global $message_div;
			       global $message;	
				   $message_div="visible_div";			 
			       $message ="Password must contain Atleast One Lowercase letter";
			       $result=false;
			   }else if(preg_match('/\d/',$password)!=1){ 
				   global $message_div;
			       global $message;	
				   $message_div="visible_div";			 
			       $message ="Password must contain Atleast One Digit";
			       $result=false;
			   }else if(preg_match('/[^a-zA-Z\d]/',$password)!=1){ 
				   global $message_div;
			       global $message;	
				   $message_div="visible_div";			 
			       $message ="Password must contain Atleast One Special Character";
			       $result=false;
			   }
		   }
		   
		  /* Password Matching Validation */
		  if($result==true){
			 if($_POST['password'] != $_POST['confirm_pass']){
			   global $message_div;
			   global $message; 
			   $message_div="visible_div";
               $message = 'Passwords should be same<br>'; 
			   $result=false;
             } 
		  }
		  
		  /* Email Validation */
		  if($result==true){
			  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
				 global $message_div;
				 global $message;
				 $message_div="visible_div";
                 $message = "Invalid UserEmail";
				 $result=false;
              }
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
             <h2>Change your password.</h2>
           </div>
           <div id="registration_form_area">
             <div id="<?php echo $message_div; ?>"><?php echo $message; ?></div>
             <form method="post" name="registration_form">
                <div class="control">                   
                   <input id="email" name="email" type="email" placeholder="Email Address" class="field" value="<?php if(isset($_POST["email"])) echo $_POST["email"];?>">
                </div>
                <div class="control">                   
                   <input id="username" name="username" type="text" placeholder="Username" class="field" value="<?php if(isset($_POST["username"])) echo $_POST["username"];?>">
                </div>
                <div class="control">                   
                   <input id="password" name="password" type="password" placeholder="Password" class="field" value="">
                </div>
                <div class="control">                   
                   <input id="confirm_pass" name="confirm_pass" type="password" placeholder="Confirm Password" class="field" value="">
                </div>         
                
                <div class="form_action">                    
                    <button type="submit" name="btn_reset" id="reset_button" class="buttons">Reset</button><br>
                    <button type="submit" name="btn_cancel" id="cancel_button" class="buttons">Cancel</button>
                </div>                
             </form>
           </div>
        </div>
    </div>
   
  </body>
</html>