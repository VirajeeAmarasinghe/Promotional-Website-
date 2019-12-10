<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Photo Albums</title>   
<link rel="stylesheet" href="../CSS/FormatManagePhotoAlbum.css">
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
  <li><a href="#">Photo Albums</a></li>
  <li><a href="ManageReleaseVideos.php">Videos</a></li> 
  <li><a href="ManageEvents.php">Events</a></li>
  <li><a href="ManageNews.php">News</a></li>
  <li><a href="ManageComments.php">Comments</a></li>
  <li><a href="ManageOneDMembers.php">One D Members</a></li>
  <li><a href="ManageProducts.php">Products</a></li>
</ul>
</div>

<?php
    
    require_once('Classes/AlbumPhoto.php');
	
    $a=new AlbumPhoto();
	
	$albumID="";
	$albumName="";

    
	$visi="disap";
	
	$source="../Images/Photo Albums/";
	$vis="disVis";
	$comboVis="visCombo";
	
	if(isset($_POST["search"])){
		if(isset($_POST["album_id"])){
			$albumID=$_POST["album_id"];			
		    $albumName=$a->getPhotoAlbumName($_POST["album_id"]);			
			
			$vis="vis";
		    $comboVis="disVisCombo";			
			
			$PhotosArray=$a->getAllThePhotosAccordingTolAlbumID($albumID);
			foreach($PhotosArray as $photoImage){
				$source="../Images/Photo Albums/".$photoImage;				
				echo '<img src="'.$source.'" class="song_images" width="503" height="300" alt="'.$photoImage.'">';
		    }			
	    }else{
			echo '<script>alert("Enter Photo Album ID")</script>';
	    }		
    }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">   
       <label for="album_id">Album ID:</label><br>
       <input type="number" name="album_id" id="album_id" class="input" value="<?php if(isset($_POST["Refreash"])){ echo $a->getMaxID();}else if(isset($_POST["album_id"])){ echo $_POST["album_id"];}else{echo $a->getMaxID();}?>"><br><br>
       <label for="album_name">Album Name:</label><br>
       <input type="text" name="album_name" id="album_name" placeholder="Album Name" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $albumName;}else if(isset($_POST["album_name"])) echo $_POST["album_name"];?>"><br><br> 
           
           
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
     
	   $albumID=$_POST["btn_delete"];
	   $a2=new AlbumPhoto();
	   $result=$a2->deletePhotoAlbum($albumID);		   
	         
   } 
   
   if(isset($_POST["add"])){
	   if(validation()==true){
		   if(isset($_FILES["banner_image"])){	   
				
				$uploadOk2=true;
				$banner_names=array();
				
				
			     //upload image to the folder    //change photo name
				 for($i=0;$i<count($_FILES['banner_image']['name']);$i++){
			          $ext=pathinfo($_FILES['banner_image']['name'][$i],PATHINFO_EXTENSION);
			          if(move_uploaded_file($_FILES['banner_image']['tmp_name'][$i],'../Images/Photo Albums/'.$_POST["album_id"].'+'.$_POST["album_name"].'+'.$i.'.'.$ext)){ 
				         $banner_names[]=$_POST["album_id"].'+'.$_POST["album_name"].'+'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading photos failed.\nData not Saved in the DB.")</script>';
						   $uploadOk2=false;
					   }
				 
				 }
				 
				 $result4=false;
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $a3=new AlbumPhoto();
					   $a3->setAlbumName($_POST["album_name"]);					   
					   
					   $result1=$a3->addNewPhotoAlbum();
					   if($result1==true){
						   for($i=0;$i<count($banner_names);$i++){
							   $a3->setAlbumId($_POST["album_id"]);
							   $a3->setPhoto($banner_names[$i]);
							   $res=$a3->addNewPhotos();
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
			          if(move_uploaded_file($_FILES['banner_image']['tmp_name'][$i],'../Images/Photo Albums/'.$_POST["album_id"].'+'.$_POST["album_name"].'+'.$i.'.'.$ext)){ 
				         $banner_names[]=$_POST["album_id"].'+'.$_POST["album_name"].'+'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading photos failed.\nData not Updated in the DB.")</script>';
						   $uploadOk2=false;
					   }
				 
				 }
				 
				 $result4=false;
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $a3=new AlbumPhoto();
					   $a3->setAlbumName($_POST["album_name"]);					   
					   
					   $result1=$a3->addNewPhotoAlbum();
					   if($result1==true){
						   $a3->deletePhotosOfPhotoAlbum($_POST["album_id"]);
						   for($i=0;$i<count($banner_names);$i++){
							   $a3->setAlbumId($_POST["album_id"]);
							   $a3->setPhoto($banner_names[$i]);
							   $res=$a3->addNewPhotos();
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
	   if(empty($_POST["album_id"])){
		   echo '<script>alert("Album ID field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["album_name"])){
		   echo '<script>alert("Album Name field is empty")</script>';
		   $result=false;
	   }
	   return $result;
   } 
       
  if(isset($_POST["del"])){
	  if(empty($_POST["album_id"])){
		  echo '<script>alert("Album ID field is empty")</script>';
	  }else{
		  $a4=new AlbumPhoto();
		  $result=$a4->deletePhotoAlbum($_POST["album_id"]);
		  if($result==true){
			  echo '<script>alert("Deleted!!!")</script>';
	      }else{
			  echo '<script>alert("Not Deleted!!!")</script>';
		  }
	  }
  }
  $visiblity="visible";
 if(isset($_POST["view_all"])||isset($_POST["btn_delete"])){
	 $release=new AlbumPhoto();
	 $releaseArray2=$release->getAllPhotoAlbums();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>Album ID</th>';
     echo '<th>Album Name</th>'; 	 
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 		 
		 echo '<tr>';	     
		 echo '<td>'.$release->getAlbumId().'</td>';
		 echo '<td>'.$release->getAlbumName().'</td>';		 
		 
		 echo '<td><form method="post"><button type="submit" value="'.$release->getAlbumId().'" name="btn_delete">Delete</button></form></td>';	 
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