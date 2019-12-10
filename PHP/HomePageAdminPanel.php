<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home Page Admin Panel</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="../CSS/FormatAdminHomePage.css">
</head>

<body>
  <nav class="navbar navbar-default">
  <div class="container-fluid">    
    <ul class="nav navbar-nav">
       <li><a class="navbar-brand" href="HomePage.php">One Direction</a></li>
      <li class="active"><a href="HomePageAdminPanel.php">Home</a></li>
      <li><a href="?link=logoutLink">Logout</a></li>
      <li><a href="#" id="welcome">Welcome <?php session_start();echo $_SESSION["admin_details"]["username"]?></a></li>        
    </ul>
  </div>
</nav>
<section id="main_wrapper">
    
</div>
<div id="second_bar">
<ul class="nav nav-tabs">
  <li class="active"><a href="#">Members</a></li>
  <li><a href="ManageReleaseAlbums.php">Release Albums</a></li>
  <li><a href="ManagePhotoAlbums.php">Photo Albums</a></li>
  <li><a href="ManageReleaseVideos.php">Videos</a></li> 
  <li><a href="ManageEvents.php">Events</a></li>
  <li><a href="ManageNews.php">News</a></li>
  <li><a href="ManageComments.php">Comments</a></li>
  <li><a href="ManageOneDMembers.php">One D Members</a></li>
  <li><a href="ManageProducts.php">Products</a></li>
</ul>
</div>
<?php
  require_once('Classes/Member.php');
  require_once('Classes/AvoidErrors.php');      
   
   $m=new Member(); 
   //to avoid object incomplete error
   
	  $err=new Errors();
	  $err->fixObject($_SESSION["admin_details"]); 
   
   if(isset($_GET["link"])){
	   unset($_SESSION["admin_details"]);
	   header("Location:LoginFormAdmin.php");
   }
  
  
  if(isset($_POST["btn_delete"])){
	   $userName=$_POST["btn_delete"];
	   $result=$m->deleteMember($userName);
	   if($result==true){
		  echo '<div id="message">Deleted Successfully</div>';  
	   }
   }
  
  
?>

<div id="form_section">
<form method="post" role="form" enctype="multipart/form-data">
  <table class="table table-striped" id="someid">
    <thead>
      <tr>
        <th>Profile Pic</th>
        <th>Username</th>
        <th>Password</th>
        <th>Email</th>
        <th>Name</th>
        <th>Country</th>
        <th>DOB</th>
        <th>Gender</th>        
        
      </tr>
    </thead>
    <tbody>
    <?php
	  $memberArray=$m->getAllMembers();
	  foreach($memberArray as $member){
		  $m=$member;
		  echo '<tr>';
		  $source="../Images/profile pictures/".$m->getImage();
		  
		  echo '<td><img src="'.$source.'" width="80" height="80"></td>';
		  echo '<td>'.$m->getUserName().'</td>';
		  echo '<td>'.$m->getPassword().'</td>';
		  echo '<td>'.$m->getEmail().'</td>';
		  echo '<td>'.$m->getName().'</td>';
		  echo '<td>'.$m->getCountry().'<td>';
		  echo '<td>'.$m->getDOB().'</td>';
		  echo '<td>'.$m->getGender().'</td>';		  
		  echo '<td><button type="submit" value="'.$m->getUserName().'" name="btn_delete">Delete</button></td>';
	      echo '</tr>';
	  }
      
	?>
      
   </tbody>
  </table>

</form>
</div>
<?php 
     
  
  if(isset($_POST["btn_save"])){	  
	  $m=new Member();
	  $m->setCountry($_POST["country"]);
	  $m->setDOB($_POST["dob"]);
	  $m->setGender($_POST["optradio"]);
	  $m->setAddress($_POST["address"]);
	  $m->setProfession($_POST["email"]);
	  $m->setShortBio($_POST["user_shortbio"]);
	  $m->updatePersonalDetails($_SESSION["user_details"]["username"]);
  }
  
  function setSelected($fieldName,$fieldValue){
	  if(isset($_POST[$fieldName])and $_POST[$fieldName]==$fieldValue){
		  echo 'selected="selected"';
	  }
  }
  
  function setValue($fieldName){
	  if(isset($_POST[$fieldName])){
		 echo $_POST[$fieldName]; 
	  }
   }
	  
  function setChecked($fieldName,$fieldValue){
	  if(isset($_POST[$fieldName])and $_POST[$fieldName]==$fieldValue){
		  echo 'checked="checked"';
	  }
  }
?>
</body>
</html>