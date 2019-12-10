<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Form-Admin</title>
    <link rel="stylesheet" href="../CSS/FormatAdminLoginForm.css">
    
   </head>
  
  <body>
    <?php
	  session_start();
	  require_once('Classes/Admin.php');
	   
      $message="";
	  $message_div="hide_div";
	  $disable="";
	  
	  if(isset($_SESSION['count_attempts'])){
		  $count_attempts=$_SESSION['count_attempts'];
	  }else{
		  $count_attempts=0;
	  }
	  
	  
	  if(isset($_POST['btn_log'])){		  
		  $resturendValue=validation();
		  if($resturendValue){
			  //login code goes here
			  $m=new Admin();
			  $password=$m->getPasswordAccordingToUsername($_POST["username"]);
			  
			  
			  if($password!=""){
				 if($password!=$_POST["password"]){
					global $message_div;
					global $message;				  	
					$message_div="visible_div";				  
					if($count_attempts<2){
						$_SESSION['count_attempts']=++$count_attempts;
						$numberOfAttempts=3-$_SESSION['count_attempts'];
						$message ="Entered username or password is incorrect.Try Again.You have ".$numberOfAttempts." more attempts.";					  
					}	else{
						
						$message="Sorry!!!Attempts exceed the limit.";
						unset($_SESSION['count_attempts']);	
						$disable="disabled";					
					}				      
				 }else{
					unset($_SESSION['count_attempts']);
					$_SESSION["admin_details"]=array("username"=>$_POST["username"],"password"=>$_POST["password"]);//associative array is used
					header("Location:HomePageAdminPanel.php");  
				}
			  }else{
				  global $message_div;
				  global $message;				  	
				  $message_div="visible_div";	
				  if($count_attempts<2){
						$_SESSION['count_attempts']=++$count_attempts;
						$numberOfAttempts=3-$_SESSION['count_attempts'];
						$message ="Entered username or password is incorrect.Try Again.You have ".$numberOfAttempts." more attempts.";					  
				  }else{
					   
						$message="Sorry!!!Attempts exceed the limit.";
						unset($_SESSION['count_attempts']);	
						$disable="disabled";			        
				  } 
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
		   } 	 
		  
         return $result; 
	  }
	  
	  if(isset($_POST["btn_cancel"])){
		  header("Location:AdminPanel.html");
	  }
      
   ?>
    
    <div id="main_content">
        <div id="title">
           <a href="HomePage.php"><h1 id="main_title">ONE DIRECTION</h1></a>
           <a href="HomePage.php"><h1 id="sub_title">1D</h1></a>
        </div>
        <div id="registration_form" class="registration_form">
           <div class="page_header">
             <h2>Log In.</h2>
           </div>
           <div id="registration_form_area">
             <div id="<?php echo $message_div; ?>"><?php echo $message; ?></div>
             <form method="post" name="registration_form">                
                <div class="control">                   
                   <input id="username" name="username" type="text" placeholder="Username" class="field" value="<?php if(isset($_POST["username"])) echo $_POST["username"];?>" required <?php echo $disable; ?>>
                </div>
                <div class="control">                   
                   <input id="password" name="password" type="password" placeholder="Password" class="field" value="" required <?php echo $disable; ?>>
                </div>
                
                <div class="form_action">
                    <button type="submit" name="btn_log" id="log_button" class="buttons" <?php echo $disable; ?>>Login</button><br>
                    <button type="submit" name="btn_cancel" id="cancel_button" class="buttons">Cancel</button>
                </div>
                <div class="action">
                    <a id="account" href="AdminRegistration.php">Need an Account?</a>
                    <a id="forget_pass" href="AdminResetPassword.php">Forgot your Password?</a>
                </div>                
             </form>
           </div>
        </div>
    </div>
   
  </body>
</html>