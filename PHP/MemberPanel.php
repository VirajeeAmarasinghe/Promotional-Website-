<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Member Profile</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../CSS/FormatMemberPanel.css">
</head>

<body>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="HomePage.php">One Direction</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="HomePage.php">Home</a></li>
      <li><a href="?link=logoutLink">Logout</a></li>
      <li><a href="#" id="welcome">Welcome <?php session_start();echo $_SESSION["user_details"]["username"]?></a></li>        
    </ul>
  </div>
</nav>
<section id="main_wrapper">
    
</div>
<div id="second_bar">
<ul class="nav nav-tabs">
  <li class="active"><a href="#">General</a></li>
  <li><a href="PersonalMemberPanel.php">Personal</a></li>  
</ul>
</div>

<?php   
   require_once('Classes/Member.php');
   require_once('Classes/AvoidErrors.php');

   $visibility="hidden";
   $message="";
   
   $m=new Member();  
   if(isset($_SESSION["user_details"])){
	   $m=$m->getMemberDetailsAccordingToUsername($_SESSION["user_details"]["username"]);
   }   

   
   //to avoid object incomplete error
	  $err=new Errors();
	  $err->fixObject($_SESSION["user_details"]); 
   
   if(isset($_GET["link"])){
	   unset($_SESSION["user_details"]);
	   header("Location:HomePage.php");
   }
   
   if($m->getImage()!="Annoymous.jpg"){
	   $source="../Images/profile pictures/".$m->getImage();
   }else{
	  $source="../Images/profile pictures/Annoymous.jpg"; 
   }
   
   
   if(isset($_POST["btn_upload"])){
	   if(isset($_FILES["upload_image"])){
		   
		   $uploadOk=1;
		      
		   //get extension of the image
		   $ext=pathinfo($_FILES["upload_image"]['name'],PATHINFO_EXTENSION);
		   
		   // Check if image file is a actual image or fake image
		   $check = getimagesize($_FILES["upload_image"]["tmp_name"]);
           if($check !== false) {                
               $uploadOk = 1;
           } else {
			   $visibility="visible_div";
               $message="File is not an image.";
               $uploadOk=0;
           }
		   
		   // Check file size
           if ($_FILES["upload_image"]["size"]>100000) {
			    $visibility="visible_div";
                $message="Sorry, your file is too large.";
                $uploadOk=0;
           }
		   
		   // Allow certain file formats
           if($ext!="jpg" && $ext!="png" && $ext!="jpeg" && $ext!="gif"){
			    $visibility="visible_div";
                $message="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
           }
		   
		   if($uploadOk===1){
			     //upload image to the folder    //change photo name
				 if(move_uploaded_file($_FILES['upload_image']['tmp_name'],'../Images/profile pictures/'.$m->getUserName().'+profile pic.'.$ext)){ 
				      $image=$m->getUserName().'+profile pic.'.$ext;
					  $_SESSION['image']=$image;					 
					  $source="../Images/profile pictures/".$_SESSION['image'];	
					  		 		 
				  }else{
					  $visibility="visible_div";
                      $message="Sorry, there was an error uploading your file.";
				  }
		    }else{
				$visibility="visible_div";
                $message="Sorry, your file was not uploaded.";
		    }
		   
      }
   }
   
   if(isset($_POST["btn_save"])){	   
	   if(!empty($_POST['name']) && isset($_SESSION['image'])){
		   
		   $m->setName($_POST['name']);
		   $m->setImage($_SESSION['image']);		   
		   $result=$m->changeMemberGeneralDetails();   	
		   
		   unset($_SESSION['image']);	   
	   }
   }
   
   ?>

<div id="form_section">
<form method="post" role="form" enctype="multipart/form-data">
  <div id="image_upload">    
     <div id="image_upload_preview"><img src="<?php echo $source ?>" width="208" height="208"></div>
     <input type="file" name="upload_image" id="upload_image" value="Upload Image"><br>
     <input type="submit" name="btn_upload" value="Upload">
     <p id="<?php echo $visibility ?>"><?php echo $message ?></p>
  </div>
  <div class="col-sm-6" id="name_div">
    <label for="name">Name:</label>
    <input name="text" name="name" class="form-control" id="name" type="text" value="<?php if(isset($_SESSION["user_details"])) echo $m->getName();?>">
  </div>
  <div class="col-sm-6" id="username_div">
    <label for="username">Username:</label>
    <input name="username" class="form-control" id="username" type="text" readonly value="<?php if(isset($_SESSION["user_details"])) echo $m->getUserName();?>">
  </div>
  <div class="col-sm-6">
    <label for="pwd">Password:</label>
    <input name="pwd" class="form-control" id="pwd" type="password" readonly value="<?php if(isset($_SESSION["user_details"])) echo $m->getPassword();?>">
  </div>
  <div class="col-sm-6">
    <label for="email">Email:</label>
    <input name="email" class="form-control" id="email" type="email" readonly value="<?php if(isset($_SESSION["user_details"])) echo $m->getEmail();?>">
  </div>
  <button type="submit" class="btn btn-default" id="save_profile" name="btn_save">Save Profile</button>
</form>
</div>

</body>
</html>