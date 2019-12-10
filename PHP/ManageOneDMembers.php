<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage One Direction Members</title>   
<link rel="stylesheet" href="../CSS/FormatManageNews.css">
<script>
    function func(){
        var ul=document.getElementById("banner_buttons");
        var newLI=document.createElement("lI");
        ul.appendChild(newLI);
        newLI.innerHTML='<input type="file" name="banner_image[]" id="more_banner_images">';
    }
	</script>
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
    
<div id="second_bar">
<ul class="nav nav-tabs">
  <li class="active"><a href="HomePageAdminPanel.php">Members</a></li>
  <li><a href="ManageReleaseAlbums.php">Release Albums</a></li>
  <li><a href="ManagePhotoAlbums.php">Photo Albums</a></li>
  <li><a href="ManageReleaseVideos.php">Videos</a></li> 
  <li><a href="ManageEvents.php">Events</a></li>
  <li><a href="ManageNews.php">News</a></li>
  <li><a href="ManageComments.php">Comments</a></li>
  <li><a href="#">One D Members</a></li>
  <li><a href="ManageProducts.php">Products</a></li>
</ul>
</div>
<?php
    
    require_once('Classes/OneDirectionMember.php');

	
    $s=new OneDirectionMember();
	$member_id="";
	$name="";
	$description="";
	$url_twitter="";
	$url_instagram="";

    
	$visi="disap";
	
	$source="../Images/oneDMemberImages/";
	$vis="disVis";
	
	
	if(isset($_POST["search"])){
		if(isset($_POST["member_id"])){			
		    $s=$s->getOneDirectionMemberDetails($_POST["member_id"]);
			
			$member_id=$s->getMemberId();
			$name=$s->getName();
			$description=$s->getDescription();
			$url_twitter=$s->getUrlTwitter();
			$url_instagram=$s->getUrlInstagram();
			
			$vis="vis";		    
			
		
			$photoArray=$s->getphotosAccordingToId($member_id);
			foreach($photoArray as $Image){
				$source="../Images/oneDMemberImages/".$Image;				
				echo '<img src="'.$source.'" class="song_images" width="300" height="300" alt="'.$Image.'">';
		    }			
	    }else{
			echo '<script>alert("Enter Member ID")</script>';
	    }		
    }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">   
       <label for="member_id">Member ID:</label><br>
       <input type="number" name="member_id" id="member_id" class="input" value="<?php if(isset($_POST["Refreash"])){ echo $s->getMaxID();}else if(isset($_POST["member_id"])){ echo $_POST["member_id"];}else{echo $s->getMaxID();}?>"><br><br>
       <label for="member_name">Member Name:</label><br>
       <input type="text" name="member_name" id="member_name" placeholder="Member Name" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $name;}else if(isset($_POST["member_name"])) echo $_POST["member_name"];?>"><br><br>
       <label for="url_twitter">URL Twitter:</label><br>
       <input type="text" name="url_twitter" id="url_twitter" class="input" placeholder="URL Twitter" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $url_twitter;}else if(isset($_POST["url_twitter"])) echo $_POST["url_twitter"];?>"><br><br>
       <label for="url_instagram">URL Instagram:</label><br>
       <input type="text" name="url_instagram" id="url_instagram" placeholder="URL Instagram" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $url_instagram;}else if(isset($_POST["url_instagram"])) echo $_POST["url_instagram"];?>"><br><br>           
           
           <br><br><label for="description">Description:</label><br>
           <textarea name="description" rows="10" cols="55" id="lyrixText"><?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $description;}else if(isset($_POST["description"])) echo $_POST["description"];?></textarea>
           <ul id="banner_buttons">
         <li>
           <label for="banner_image">Upload Photo:</label><br><br>
           <input type="file" name="banner_image[]" >
           <input type="button" name="AddMore" id="AddMore" value="Add Another Banner Image" onClick="func()">
         </li>
       </ul>
                    
           
       <div id="buttons">
         <button type="submit" name="add">Add New</button>
         <button type="submit" name="del">Delete</button>
         <button type="submit" name="update">Update</button>
         <button type="submit" name="search">Search</button>
         <button type="submit" name="view_all">View All</button>
         <button type="submit" name="Refreash">Refreash</button>
       </div>
     </form>   
</div>
  


<?php
    require_once('Classes/AvoidErrors.php');      
   
    
   //to avoid object incomplete error
   
	  $err=new Errors();
	  $err->fixObject($_SESSION["admin_details"]); 
   
   if(isset($_GET["link"])){
	   unset($_SESSION["admin_details"]);
	   header("Location:LoginFormAdmin.php");
   }
   
   if(isset($_POST["btn_delete"])){	
     
	   $memberID=$_POST["btn_delete"];
	   $s=new OneDirectionMember();
	   $result=$s->deleteMember($memberID);		   
	           
   } 
   
   if(isset($_POST["add"])){
	   if(validation()==true){
		   if(isset($_FILES["banner_image"])){	   
				
				$uploadOk2=true;
				$banner_names=array();
				
				
			     //upload image to the folder    //change photo name
				 for($i=0;$i<count($_FILES['banner_image']['name']);$i++){
			          $ext=pathinfo($_FILES['banner_image']['name'][$i],PATHINFO_EXTENSION);
			          if(move_uploaded_file($_FILES['banner_image']['tmp_name'][$i],'../Images/oneDMemberImages/'.$_POST["member_id"].'+'.$_POST["member_name"].'+'.$i.'.'.$ext)){ 
				         $banner_names[]=$_POST["member_id"].'+'.$_POST["member_name"].'+'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading image failed.\nData not Saved in the DB.")</script>';
						   $uploadOk2=false;
					   }
				 
				 }
				 
				 $result4=false;
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $s=new OneDirectionMember;
					   $memberID2=$_POST["member_id"];
					   $s->setName($_POST["member_name"]);
					   $s->setDescription($_POST["description"]);
					   $s->setUrlTwitter($_POST["url_twitter"]);
					   $s->setUrlInstagram($_POST["url_instagram"]);
					   
					   $result1=$s->addNewMember();
					   if($result1==true){
						   for($i=0;$i<count($banner_names);$i++){					      						   
							   $s->setMemberId($memberID2);
							   $s->setOneImage($banner_names[$i]);
							   $res=$s->addNewMemberPhotos();
							   if($res==true){
								   $result4=true;
							   }else{
								   $result4=false;
							   }
						    }
							if($result4==true){
								echo '<script>alert("Saved Succefully.")</script>';
						    }						   
					   }else{
						   echo '<script>alert("Sorry,Error Occurred.")</script>';
					   }				   
				   }					   
				   
		    }
	   }
   }
   
   if(isset($_POST["update"])){
	   if(validation()==true){
		   if(isset($_FILES["banner_image"])){	   
				
				$uploadOk2=true;
				$banner_names=array();
				
				
			     //upload image to the folder    //change photo name
				 for($i=0;$i<count($_FILES['banner_image']['name']);$i++){
			          $ext=pathinfo($_FILES['banner_image']['name'][$i],PATHINFO_EXTENSION);
			          if(move_uploaded_file($_FILES['banner_image']['tmp_name'][$i],'../Images/oneDMemberImages/'.$_POST["member_id"].'+'.$_POST["member_name"].'+'.$i.'.'.$ext)){ 
				         $banner_names[]=$_POST["member_id"].'+'.$_POST["member_name"].'+'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading image failed.\nData not Saved in the DB.")</script>';
						   $uploadOk2=false;
					   }
				 
				 }
				 
				 $result4=false;
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $s=new OneDirectionMember;
					   $s->setName($_POST["member_name"]);
					   $s->setDescription($_POST["description"]);
					   $s->setUrlTwitter($_POST["url_twitter"]);
					   $s->setUrlInstagram($_POST["url_instagram"]);
					   
					   $result1=$s->updateMemberDetails($_POST["member_id"]);
					   if($result1==true){
						   $s->deleteMemberPhotos($_POST["member_id"]);
						   for($i=0;$i<count($banner_names);$i++){							   
							   $s->setMemberId($_POST["member_id"]);
							   $s->setOneImage($banner_names[$i]);
							   $res=$s->addNewMemberPhotos();
							   if($res==true){
								   $result4=true;
							   }else{
								   $result4=false;
							   }
						    }
							if($result4==true){
								echo '<script>alert("Updated Succefully.")</script>';
						    }						   
					   }else{
						   echo '<script>alert("Sorry,Error Occurred.")</script>';
					   }				   
				   }					   
				   
		    }
	   }
   }
   
   function validation(){
	   $result=true;
	   if(empty($_POST["member_id"])){
		   echo '<script>alert("Member ID field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["member_name"])){
		   echo '<script>alert("Member Name field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_twitter"])){
		   echo '<script>alert("Url Twitter field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_instagram"])){
		   echo '<script>alert("Url Instagram field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["description"])){
		   echo '<script>alert("Description field is empty")</script>';
		   $result=false;
	   }
	   return $result;
   } 
       
  if(isset($_POST["del"])){
	  if(empty($_POST["member_id"])){
		  echo '<script>alert("Member ID field is empty")</script>';
	  }else{
		  $s=new OneDirectionMember();
		  $result=$s->deleteMember($_POST["member_id"]);
		  if($result==true){
			  echo '<script>alert("Deleted!!!")</script>';
	      }else{
			  echo '<script>alert("Not Deleted!!!")</script>';
		  }
	  }
  }
  $visiblity="visible";
 if(isset($_POST["view_all"])||isset($_POST["btn_delete"])){
	 $release=new OneDirectionMember();
	 $releaseArray2=$release->getAllOneDirectionMemberDetails();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>Member ID</th>';
     echo '<th>Member Name</th>';     
	 echo '<th>Description</th>';     
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 		 
		 echo '<tr>';	     
		 echo '<td>'.$release->getMemberId().'</td>';
		 echo '<td>'.$release->getName().'</td>';		 
		 echo '<td>'.$release->getDescription().'</td>';
		 echo '<td><form method="post"><button type="submit" value="'.$release->getMemberId().'" name="btn_delete">Delete</button></form></td>';	 
	     echo '</tr>';
		 
     }	
	 echo '</tbody>'; 	
	 echo '</table>';
	 echo '</div>'; 
 }
 
  if(isset($_POST["Refreash"])){	 
	  $visiblity="hidden";
	  $visi="disap";
  }
  
  
  
?>


</section>
</body>
</html>