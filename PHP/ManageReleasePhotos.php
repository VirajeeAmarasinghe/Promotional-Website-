<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Release Photos</title>   
<link rel="stylesheet" href="../CSS/FormatManageReleasesPhotos.css">

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
  <li><a href="javascript:history.go(-1)" title="Return to the previous page">Go Back</a></li>
  <li><a href="ManageReleaseAlbums.php">Manage Releases</a></li>
  <li><a href="ManageReleasePhotos.php" class="this_form">Release Photos</a></li>
  <li><a href="ManageReleaseSongs.php">Release Songs</a></li>
  <li><a href="ManageReleaseVideos.php">Release Videos</a></li>
  <li><a href="ManageSubBannerImages.php">Release Sub-banner images</a></li> 
  </ul>
</div>
<?php
    
    require_once('Classes/Photo.php');
	require_once('Classes/ReleaseAlbum.php');
    $rel=new Photo();
	$photo_id="";
	$photo="";
	$photo_title="";
	$release_id="";
  
	$visi="disap";
	$source="../Images/Releases Photos/";
	$vis="disVis";
	$comboVis="visCombo";
	if(isset($_POST["search"])){
		if(isset($_POST["photo_id"])){			
		    $rel=$rel->getPhotosAccordingToPhotoID($_POST["photo_id"]);
			
				$photo_id=$_POST["photo_id"];
				$photo=$rel->getPhoto();
				$photo_title=$rel->getPhotoTitle();
				$release_id=$rel->getReleaseId();
				
				$vis="vis";
				$comboVis="disVisCombo";
				$source="../Images/Releases Photos/".$photo;
				$visi="app";
		    			
	    }else{
			echo '<script>alert("Enter Photo ID")</script>';
	    }		
    }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">
   <div id="<?php echo $visi; ?>"><img src="<?php echo $source;?>" width="400" height="auto" alt="No Photo"></div>
       <label for="rel_id">Photo ID:</label><br>
       <input type="number" name="photo_id" id="photo_id" class="input" min="1" value="<?php if(isset($_POST["Refreash"])){ echo $rel->getMaxID();}else if(isset($_POST["photo_id"])){ echo $_POST["photo_id"];}else{echo $rel->getMaxID();}?>"><br><br>
       <label for="title">Photo Title:</label><br>
       <input type="text" name="title" id="title" placeholder="Photo Title" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $photo_title;}else if(isset($_POST["title"])) echo $_POST["title"];?>"><br><br>
       <label for="rel_date">Release ID:</label><br>
       <select name="rel_date" class="input" id="<?php echo $comboVis; ?>">
         <?php 
		   $release=new ReleaseAlbum();
		   $releaseArray=$release->GetReleases();
		   foreach($releaseArray as $releaseAlbum){
			   $release=$releaseAlbum;	
			   ?>
               
			   <option value="<?php echo $release->getReleaseID();?>"><?php echo $release->getReleaseID();?></option>';<?php		   
		   }
		 ?>
       </select>     
           <input type="text" disabled id="<?php echo $vis; ?>" class="input" value="<?php if(isset($_POST["search"])) echo $release_id;?>">
           <br><br>
           
           <label for="photo_image">Upload Photo:</label><br><br>
           <input type="file" name="photo_image">           
           
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
     
	   $photoID=$_POST["btn_delete"];
	   $p=new Photo();
	   $result=$p->deletePhoto($photoID);
	      
   } 
   
   if(isset($_POST["add"])){
	   if(validation()==true){
		   if(isset($_FILES["photo_image"])){
			   
			   $uploadOk=1;
		      
		       //get extension of the image
		       $ext=pathinfo($_FILES["photo_image"]['name'],PATHINFO_EXTENSION);
		   
		       // Check if image file is a actual image or fake image
		       $check =getimagesize($_FILES["photo_image"]["tmp_name"]);
			   
               if($check !== false) {                
                  $uploadOk = 1;
               }else {
			      echo '<script>alert("File is not an image")</script>';                
                  $uploadOk=0;
               }
		   
		       // Check file size
               if ($_FILES["photo_image"]["size"]>1000000) {
			       echo '<script>alert("Sorry, your file is too large.")</script>';                
                   $uploadOk=0;
                }
		   
		        // Allow certain file formats
                if($ext!="jpg" && $ext!="png" && $ext!="jpeg" && $ext!="gif"){
			        echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';                    $uploadOk = 0;
                }
				
				$uploadOk2=false;
				if($uploadOk===1){
			     //upload image to the folder    //change photo name
				 if(move_uploaded_file($_FILES['photo_image']['tmp_name'],'../Images/Releases Photos/'.$_POST["title"].'.'.$ext)){ 
				      $image=$_POST["title"].'.'.$ext;
					  $_SESSION['image']=$image;		  	
					  $uploadOk2=true;		 		 
				  }else{
					  echo '<script>alert("Sorry, there was an error uploading your file.")</script>';             
				  }
		        }else{			
                    echo '<script>alert("Sorry, there was an error uploading your file.")</script>';             
		        } 			   
				 
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $p=new Photo();
					   $p->setPhotoId($_POST["photo_id"]);
					   $p->setPhotoTitle($_POST["title"]);					 
					   $p->setReleaseId($_POST["rel_date"]);
					   $p->setPhoto($_SESSION["image"]);
					   
					   $result1=$p->addNewPhoto();
					   if($result1==true){
						   echo '<script>alert("Saved Succefully.")</script>';
					   }else{
						   echo '<script>alert("Sorry,Error Occurred.")</script>';
					   }				   
				   }					   
				   
		   }else{
			   echo '<script>alert("Select Image.")</script>';
			}
	   }
   }
   
   if(isset($_POST["update"])){
	   if(validation()==true){   
			if(isset($_FILES["photo_image"])){
			   
			   $uploadOk=1;
		      
		       //get extension of the image
		       $ext=pathinfo($_FILES["photo_image"]['name'],PATHINFO_EXTENSION);
		   
		       // Check if image file is a actual image or fake image
		       $check =getimagesize($_FILES["photo_image"]["tmp_name"]);
			   
               if($check !== false) {                
                  $uploadOk = 1;
               }else {
			      echo '<script>alert("File is not an image")</script>';                
                  $uploadOk=0;
               }
		   
		       // Check file size
               if ($_FILES["photo_image"]["size"]>1000000) {
			       echo '<script>alert("Sorry, your file is too large.")</script>';                
                   $uploadOk=0;
                }
		   
		        // Allow certain file formats
                if($ext!="jpg" && $ext!="png" && $ext!="jpeg" && $ext!="gif"){
			        echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';                    $uploadOk = 0;
                }
				
				$uploadOk2=false;
				if($uploadOk===1){
			     //upload image to the folder    //change photo name
				 if(move_uploaded_file($_FILES['photo_image']['tmp_name'],'../Images/Releases Photos/'.$_POST["title"].'.'.$ext)){ 
				      $image=$_POST["title"].'.'.$ext;
					  $_SESSION['image']=$image;		  	
					  $uploadOk2=true;		 		 
				  }else{
					  echo '<script>alert("Sorry, there was an error uploading your file.")</script>';             
				  }
		        }else{			
                    echo '<script>alert("Sorry, there was an error uploading your file.")</script>';             
		        } 			   
				 
				   
				   //if only image uplaoding was successful, then data will be updated in the database.
				   if($uploadOk2==true){
					   $p=new Photo();
					   $p->setPhotoId($_POST["photo_id"]);
					   $p->setPhotoTitle($_POST["title"]);					 
					   $p->setReleaseId($_POST["rel_date"]);
					   $p->setPhoto($_SESSION["image"]);
					   
					   $result3=$p->updatePhotoDetails($_POST["photo_id"]);
					   
					   if($result3==true){
						   echo '<script>alert("Updated Succefully.")</script>';
					   }else{
						   echo '<script>alert("Sorry,Error Occurred.")</script>';
					   }				   
				   }					   
				   
		   }else{
			   echo '<script>alert("Select Image.")</script>';
			}	  
	   }
   }
   
   function validation(){
	   $result=true;
	   if(empty($_POST["photo_id"])){
		   echo '<script>alert("Photo ID field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["title"])){
		   echo '<script>alert("Title field is empty")</script>';
		   $result=false;
	   }
	   return $result;
   }
    
  if(isset($_POST["del"])){
	  if(empty($_POST["photo_id"])){
		  echo '<script>alert("Photo ID field is empty")</script>';
	  }else{
		  $r=new Photo();
		  $result=$r->deletePhoto($_POST["photo_id"]);
		  if($result==true){
			  echo '<script>alert("Deleted!!!")</script>';
	      }else{
			  echo '<script>alert("Not Deleted!!!")</script>';
		  }
	  }
  }
  $visiblity="visible";
  echo '<form method="post">';
 if(isset($_POST["view_all"])||isset($_POST["btn_delete"])){
	 $release=new Photo();
	 $releaseArray2=$release->getPhotos();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>Photo</th>';
     echo '<th>Photo ID</th>';
     echo '<th>Title</th>';
     echo '<th>Release ID</th>';     
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 $source2="../Images/Releases Photos/".$release->getPhoto();		 
		 echo '<tr>';
	     echo '<td><img src="'.$source2.'" width="100" height="100"></td>';
		 echo '<td>'.$release->getPhotoId().'</td>';
		 echo '<td>'.$release->getPhotoTitle().'</td>';
		 echo '<td>'.$release->getReleaseId().'</td>';	
		 echo '<td><button type="submit" value="'.$release->getPhotoId().'" name="btn_delete">Delete</button></td>';
	     echo '</tr>';
		 
     }	
	 echo '</tbody>'; 	
	 echo '</table>';
	 echo '</div>'; 
	 echo '</form>';
 }
 
  if(isset($_POST["Refreash"])){	 
	  $visiblity="hidden";
	  $visi="disap";
  }
  
  
  
?>


</section>
</body>
</html>