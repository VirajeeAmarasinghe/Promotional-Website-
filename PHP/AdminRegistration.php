<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin Registration Form</title>
    <link rel="stylesheet" href="../CSS/FormatAdminRegistration.css">
  </head>
  
  <body>
    <?php
	  require_once('Classes/Admin.php');
	  
      $message="";
	  $message_div="hide_div";
	  
	  if(isset($_POST['btn_register'])){		  
		  $resturendValue=validation();
		  if($resturendValue){
			  $m=new Admin();
			  $returnedResult=$m->checkUserAccount($_POST["username"]);
			  //if there is no account with the same username
			  if($returnedResult==false){			  	
				   
					   $member=new Admin();
					   
					   $member->setUserName($_POST["username"]);					   
					   $member->setPass($_POST["password"]);
					   
					   $result=$member->addNewAdmin();
					   if($result==true){
						   header("Location:LoginFormAdmin.php");
					   }				   			       
			  }else{
				 global $message_div;
			     global $message;	
				 $message_div="visible_div";			 
			     $message ="Already There is a Account on Entered Username."; 				
			  }
		  } 
	  }
	  
	  function validation(){
		  $result=true;
		  /* Form Required Field Validation */  
         		  
		   			  
		    if(empty($_POST["username"])) {
			   global $message_div;
			   global $message;	
			   $message_div="visible_div";			 
			   $message ="Username field is required";
			   $result=false; 			   
		   }else if(empty($_POST["password"])) {
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
		  
		  
         return $result; 
	  }
	  
	  if(isset($_POST["btn_cancel"])){
		  header("Location:LoginFormAdmin.php");
	  }
      
   ?>
   
    <div id="main_content">
        <div id="title">
           <a href="HomePage.php"><h1 id="main_title">ONE DIRECTION</h1></a>
           <a href="HomePage.php"><h1 id="sub_title">1D</h1></a>
        </div>
        <div id="registration_form" class="registration_form">
           <div class="page_header">
             <h2>Sign up for an account</h2>
           </div>
           <div id="registration_form_area">
             <div id="<?php echo $message_div; ?>"><?php echo $message; ?></div>
             <form method="post" name="registration_form">
                
                <div class="control">                   
                   <input id="username" name="username" type="text" placeholder="Username" class="field" value="<?php if(isset($_POST["username"])) echo $_POST["username"];?>" required>
                </div>
                <div class="control">                   
                   <input id="password" name="password" type="password" placeholder="Password" class="field" value="" required>
                </div>
                <div class="control">                   
                   <input id="confirm_pass" name="confirm_pass" type="password" placeholder="Confirm Password" class="field" value="" required>
                </div>               
                
                <div class="form_action">
                    <button type="submit" name="btn_register" id="register_button" class="buttons">Register</button><br>
                    <button type="submit" name="btn_cancel" id="cancel_button" class="buttons">Cancel</button>
                </div>
                <div class="action">
                    <a id="account" href="LoginFormAdmin.php">Already have an Account?</a>
                    <a id="forget_pass" href="AdminResetPassword.php">Forgot your Password?</a>
                </div>
                <div id="terms_and_policy">
                   <p>By creating an account you agree to our Terms and Conditions</p>
                </div>
             </form>
           </div>
        </div>
    </div>
   
  </body>
</html>