<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Sub-Banner Images</title>   
<link rel="stylesheet" href="../CSS/FormatManageSubBannerImages.css">

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
  <li><a href="ManageReleasePhotos.php">Release Photos</a></li>
  <li><a href="ManageReleaseSongs.php">Release Songs</a></li>
  <li><a href="ManageReleaseVideos.php">Release Videos</a></li>
  <li><a href="ManageSubBannerImages.php" class="this_form">Release Sub-banner images</a></li> 
  </ul>
</div>
<?php
    
    require_once('Classes/SubBannerImage.php');
	require_once('Classes/ReleaseAlbum.php');
	
    $sub1=new SubBannerImage();
	$banner_id="";
	$banner="";
	$banner_title="";
	$fb_url="";
	$twit_url="";
	$google_url="";
	$release_id="";
  
	$visi="disap";
	$source="../Images/Sub Banner Images/";
	$vis="disVis";
	$comboVis="visCombo";
	if(isset($_POST["search"])){
		if(isset($_POST["banner_id"])){			
		    $sub1=$sub1->getBannersAccordingToBannerID($_POST["banner_id"]);
			
				$banner_id=$sub1->getSubBannerImageId();
				$banner=$sub1->getSubBannerImageName();
				$banner_title=$sub1->getSubBannerImageTitle();
				$fb_url=$sub1->getFbShareUrl();
				$twit_url=$sub1->getTwitShareUrl();
				$google_url=$sub1->getGoogleShareUrl();
				$release_id=$sub1->getReleaseId();
				
				$vis="vis";
				$comboVis="disVisCombo";
				$source="../Images/Sub Banner Images/".$banner;
				$visi="app";
		    			
	    }else{
			echo '<script>alert("Enter Sub-banner ID")</script>';
	    }		
    }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">
   <div id="<?php echo $visi; ?>"><img src="<?php echo $source;?>" width="400" height="auto" alt="No Photo"></div>
       <label for="banner_id">Banner ID:</label><br>
       <input type="number" name="banner_id" id="banner_id" class="input" min="1" value="<?php if(isset($_POST["Refreash"])){ echo $sub1->getMaxID();}else if(isset($_POST["banner_id"])){ echo $_POST["banner_id"];}else{echo $sub1->getMaxID();}?>"><br><br>
       <label for="title">Banner Title:</label><br>
       <input type="text" name="title" id="title" placeholder="Banner Title" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $banner_title;}else if(isset($_POST["title"])) echo $_POST["title"];?>"><br><br>
       <label for="url_fb">FB Url:</label><br>
       <input type="text" name="url_fb" id="url_fb" placeholder="FB Url" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $fb_url;}else if(isset($_POST["url_fb"])) echo $_POST["url_fb"];?>"><br><br>
       <label for="url_twit">Twitter Url:</label><br>
       <input type="text" name="url_twit" id="url_twit" placeholder="Twitter Url" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $twit_url;}else if(isset($_POST["url_twit"])) echo $_POST["url_twit"];?>"><br><br>
       <label for="url_google">Google Url:</label><br>
       <input type="text" name="url_google" id="url_google" placeholder="Google Url" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $google_url;}else if(isset($_POST["url_google"])) echo $_POST["url_google"];?>"><br><br>
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
           
           <label for="photo_image">Upload Banner Image:</label><br><br>
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
     
	   $bannerID=$_POST["btn_delete"];
	   $b=new SubBannerImage();
	   $result=$b->deleteBanner($bannerID);
	      
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
				 if(move_uploaded_file($_FILES['photo_image']['tmp_name'],'../Images/Sub Banner Images/'.$_POST["banner_id"].'+'.$_POST["title"].'+'.$_POST["rel_date"].'.'.$ext)){ 
				      $image=$_POST["banner_id"].'+'.$_POST["title"].'+'.$_POST["rel_date"].'.'.$ext;
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
					   $s2=new SubBannerImage();
					   $s2->setSubBannerImageId($_POST["banner_id"]);
					   $s2->setSubBannerImageName($_SESSION["image"]);					 
					   $s2->setSubBannerImageTitle($_POST["title"]);
					   $s2->setFbShareUrl($_POST["url_fb"]);
					   $s2->setTwitShareUrl($_POST["url_twit"]);
					   $s2->setGoogleShareUrl($_POST["url_google"]);
					   $s2->setReleaseId($_POST["rel_date"]);
					   
					   $result1=$s2->addNewBanner();
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
				 if(move_uploaded_file($_FILES['photo_image']['tmp_name'],'../Images/Sub Banner Images/'.$_POST["banner_id"].'+'.$_POST["title"].'+'.$_POST["rel_date"].'.'.$ext)){ 
				      $image=$_POST["banner_id"].'+'.$_POST["title"].'+'.$_POST["rel_date"].'.'.$ext;
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
					   $s2=new SubBannerImage();
					   $s2->setSubBannerImageId($_POST["banner_id"]);
					   $s2->setSubBannerImageName($_SESSION["image"]);					 
					   $s2->setSubBannerImageTitle($_POST["title"]);
					   $s2->setFbShareUrl($_POST["url_fb"]);
					   $s2->setTwitShareUrl($_POST["url_twit"]);
					   $s2->setGoogleShareUrl($_POST["url_google"]);
					   $s2->setReleaseId($_POST["rel_date"]);
					   
					   $result1=$s2->updatePhotoDetails($_POST["banner_id"]);
					   if($result1==true){
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
	   if(empty($_POST["banner_id"])){
		   echo '<script>alert("Banner ID field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["title"])){
		   echo '<script>alert("Title field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_fb"])){
		   echo '<script>alert("FB Url field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_twit"])){
		   echo '<script>alert("Twit Url field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_google"])){
		   echo '<script>alert("Google Url field is empty")</script>';
		   $result=false;
	   }
	   return $result;
   }
    
  if(isset($_POST["del"])){
	  if(empty($_POST["banner_id"])){
		  echo '<script>alert("Banner ID field is empty")</script>';
	  }else{
		  $r=new SubBannerImage;
		  $result=$r->deleteBanner($_POST["banner_id"]);
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
	 $release=new SubBannerImage();
	 $releaseArray2=$release->getBanners();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>Image</th>';
     echo '<th>Banner ID</th>';
     echo '<th>Title</th>';
     echo '<th>Release ID</th>';     
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 $source2="../Images/Sub Banner Images/".$release->getSubBannerImageName();		 
		 echo '<tr>';
	     echo '<td><img src="'.$source2.'" width="100" height="100"></td>';
		 echo '<td>'.$release->getSubBannerImageId().'</td>';
		 echo '<td>'.$release->getSubBannerImageTitle().'</td>';
		 echo '<td>'.$release->getReleaseId().'</td>';	
		 echo '<td><button type="submit" value="'.$release->getSubBannerImageId().'" name="btn_delete">Delete</button></td>';
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