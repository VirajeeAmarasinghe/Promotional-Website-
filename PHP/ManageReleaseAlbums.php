<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Releases</title>   
<link rel="stylesheet" href="../CSS/FromatAdminReleases.css">
<script>
    function func(){
        var ul=document.getElementById("banner_buttons");
        var newLI=document.createElement("lI");
        ul.appendChild(newLI);
        newLI.innerHTML='<input type="file" name="banner_image[]" id="more_banner_images">';
    }
	function func2(){
        var ul=document.getElementById("album_cover_buttons");
        var newLI=document.createElement("lI");
        ul.appendChild(newLI);
        newLI.innerHTML='<input type="file" name="cover_image[]" id="more_cover_images">';
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
  <li><a href="javascript:history.go(-1)" title="Return to the previous page">Go Back</a></li>
  <li><a href="#" class="this_form">Manage Releases</a></li>
  <li><a href="ManageReleasePhotos.php">Release Photos</a></li>
  <li><a href="ManageReleaseSongs.php">Release Songs</a></li>
  <li><a href="ManageReleaseVideos.php">Release Videos</a></li>
  <li><a href="ManageSubBannerImages.php">Release Sub-banner images</a></li> 
  </ul>
</div>
<?php
    require_once('Classes/ReleaseAlbum.php');
    $rel=new ReleaseAlbum();
	$title="";
	$releaseDate="";
	$url_of_1D_store="";
	$url_of_googleplay="";
	$url_of_amazon="";
	$url_of_itunes="";
	if(isset($_POST["search"])){
		if(isset($_POST["rel_id"])){
			$rele=new ReleaseAlbum();
		    $releasearray=$rel->GetReleasesAccordingToId($_POST["rel_id"]);
			foreach($releasearray as $obj){
				$rele=$obj;
				$title=$rele->getTitle();
				$releaseDate=$rele->getReleasedate();
				$url_of_1D_store=$rele->getUrlOfOneDStore();
				$url_of_googleplay=$rele->getUrlOfGooglePlay();
				$url_of_amazon=$rele->getUrlOfAmazon();
				$url_of_itunes=$rele->getUrlOfITunes();
			}
	    }else{
			echo '<script>alert("Enter ReleaseID")</script>';
	    }		
    }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">
       <label for="rel_id">Release ID:</label><br>
       <input type="number" name="rel_id" id="rel_id" class="input" value="<?php if(isset($_POST["Refreash"])){ echo $rel->getMaxID();}else if(isset($_POST["rel_id"])){ echo $_POST["rel_id"];}else{echo $rel->getMaxID();}?>"><br><br>
       <label for="title">Title:</label><br>
       <input type="text" name="title" id="title" placeholder="Album Title" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $title;}else if(isset($_POST["title"])) echo $_POST["title"];?>"><br><br>
       <label for="rel_date">Release Date:</label><br>
       <input type="date" name="rel_date" id="rel_date" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $releaseDate;}else if(isset($_POST["rel_date"])) echo $_POST["rel_date"];?>"><br><br>
       <label for="url_1D_store">URL Of 1D Store:</label><br>
       <input type="text" name="url_1D_store" id="url_1D_store" class="input" placeholder="Url Of 1D Store" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $url_of_1D_store;}else if(isset($_POST["url_1D_store"])) echo $_POST["url_1D_store"];?>"><br><br>
       <label for="url_googlePlay">URL Of Googleplay:</label><br>
       <input type="text" name="url_googlePlay" id="url_googlePlay" placeholder="Url Of GooglePlay" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $url_of_googleplay;}else if(isset($_POST["url_googlePlay"])) echo $_POST["url_googlePlay"];?>"><br><br>
       <label for="url_amazon">URL Of Amazon:</label><br>
       <input type="text" name="url_amazon" id="url_amazon" placeholder="Url Of Amazon" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $url_of_amazon;}else if(isset($_POST["url_amazon"])) echo $_POST["url_amazon"];?>"><br><br>
       <label for="url_itunes">URL Of iTunes:</label><br>
       <input type="text" name="url_itunes" id="url_itunes" placeholder="Url Of iTunes" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $url_of_itunes;}else if(isset($_POST["url_itunes"])) echo $_POST["url_itunes"];?>"><br><br>
       <ul id="banner_buttons">
         <li>
           <label for="banner_image">Upload Banner Image:</label><br><br>
           <input type="file" name="banner_image[]" >
           <input type="button" name="AddMore" id="AddMore" value="Add Another Banner Image" onClick="func()">
         </li>
       </ul>
       <ul id="album_cover_buttons">
         <li>
           <label for="cover_image">Upload Album Cover Photo:</label><br><br>
           <input type="file" name="cover_image[]">
           <input type="button" name="Addmorecovers" id="Addmorecovers" value="Add Another Cover Photo" onClick="func2()">
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
   
   if(isset($_POST["add"])){
	   if(validation()==true){
		   if(isset($_FILES["banner_image"])){
			   if(isset($_FILES["cover_image"])){
				   
				   $uploadOk=true; //to check whether the uploading was succeful or not
				   //uploading banner images to release banner images folder
				   $banner_names=array();
				   
				   for($i=0;$i<count($_FILES['banner_image']['name']);$i++){
			          $ext=pathinfo($_FILES['banner_image']['name'][$i],PATHINFO_EXTENSION);
			          if(move_uploaded_file($_FILES['banner_image']['tmp_name'][$i],'../Images/Releases Banner Images/'.$_POST["title"].'+BannerImage+'.$i.'.'.$ext)){ 
				         $banner_names[]=$_POST["title"].'+'.'BannerImage'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading-banner image failed.\nData not Saved in the DB.")</script>';
						   $uploadOk=false;
					   }
		           }
				   
				   //uploading cover photos to album cover photos folder
				   $cover_names=array();
				   
				   for($i=0;$i<count($_FILES['cover_image']['name']);$i++){
			          $ext=pathinfo($_FILES['cover_image']['name'][$i],PATHINFO_EXTENSION);
			          if(move_uploaded_file($_FILES['cover_image']['tmp_name'][$i],'../Images/Sub Banner Images/Album Cover Photos/'.$_POST["title"].'+CoverPhoto+'.$i.'.'.$ext)){ 
				         $cover_names[]=$_POST["title"].'+'.'CoverPhoto'.'+'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading-cover image failed.\nData not Saved in the DB.")</script>';
						   $uploadOk=false;
					   }
		           }
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk==true){
					   $r=new ReleaseAlbum();
					   $r->setReleaseID($_POST["rel_id"]);
					   $releaseID=$_POST["rel_id"];
					   $r->setTitle($_POST["title"]);
					   $r->setReleaseDate($_POST["rel_date"]);
					   $r->setUrlOfOneDStore($_POST["url_1D_store"]);
					   $r->setUrlOfGooglePlay($_POST["url_googlePlay"]);
					   $r->setUrlOfAmazon($_POST["url_amazon"]);
					   $r->setUrlOfITunes($_POST["url_itunes"]);
					   
					   $result1=$r->addNewRelease();
					   $result2=false;
					   
					   //if release is saved successfully other images are saved.
					   if($result1==true){
						   for($j=0;$j<count($banner_names);$j++){
							   echo $r->setReleaseID($releaseID);
							   
							   $r->setBannerImage($banner_names[$j]);
							   $res=$r->addNewBannerImages();
							   if($res==false){
								   $result2=false;
							   }else{
								   $result2=true;
							   }
						   }
						   for($k=0;$k<count($cover_names);$k++){
							   echo $r->setReleaseID($releaseID);
							  
							   $r->setCoverImage($banner_names[$k]);
							   $res=$r->addNewCoverImages();
							   if($res==false){
								   $result2=false;
							   }else{
								   $result2=true;
							   }
						   }
					   }
					   if($result2==true){
						   echo '<script>alert("Saved Successfully")</script>';
					   }else{
						   echo '<script>alert("Error occurred while saving images")</script>';
					   }
					   
				   }
			   }else{
				   echo '<script>alert("Select Cover Photo")</script>';
			   }
		   }else{
			   echo '<script>alert("Select Banner Image")</script>';
		   }
	   }
   }
   
   if(isset($_POST["update"])){
	   if(validation()==true){   
				  
			 $r=new ReleaseAlbum();
			 $r->setReleaseID($_POST["rel_id"]);
			 $releaseID=$_POST["rel_id"];
			 $r->setTitle($_POST["title"]);
			 $r->setReleaseDate($_POST["rel_date"]);
			 $r->setUrlOfOneDStore($_POST["url_1D_store"]);
			 $r->setUrlOfGooglePlay($_POST["url_googlePlay"]);
			 $r->setUrlOfAmazon($_POST["url_amazon"]);
			 $r->setUrlOfITunes($_POST["url_itunes"]);
			 
			 $result1=$r->updatePersonalDetails($_POST["rel_id"]);
			 
			 
			 //if release is saved successfully other images are saved.
			 if($result1==true){
				 echo '<script>alert("Updated Successfully.")</script>';
			 }else{
				 echo '<script>alert("Error Occurred While Updating!!!")</script>';
			 }
		}
   }
   
   function validation(){
	   $result=true;
	   if(empty($_POST["rel_id"])){
		   echo '<script>alert("Release ID field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["title"])){
		   echo '<script>alert("Title field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["rel_date"])){
		   echo '<script>alert("Release Date field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_1D_store"])){
		   echo '<script>alert("URL of 1D store field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_googlePlay"])){
		   echo '<script>alert("URL of googleplay field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_amazon"])){
		   echo '<script>alert("URL of amazon field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_itunes"])){
		   echo '<script>alert("URL of itunes field is empty")</script>';
		   $result=false;
	   }
	   return $result;
   } 
  if(isset($_POST["del"])){
	  if(empty($_POST["rel_id"])){
		  echo '<script>alert("Release ID field is empty")</script>';
	  }else{
		  $r=new ReleaseAlbum();
		  $result=$r->deleteRelease($_POST["rel_id"]);
		  if($result==true){
			  echo '<script>alert("Deleted!!!")</script>';
	      }else{
			  echo '<script>alert("Not Deleted!!!")</script>';
		  }
	  }
  }
  $visiblity="visible";
 if(isset($_POST["view_all"])){
	 $release=new ReleaseAlbum();
	 $releaseArray2=$release->GetReleases();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
     echo '<th>Release ID</th>';
     echo '<th>Title</th>';
     echo '<th>Release Date</th>';
     echo '<th>URL of 1D Store</th>';
     echo '<th>URL of GooglePlay</th>';
     echo '<th>URL of Amazon</th>';
     echo '<th>URL of Itunes</th>';
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 
		 echo '<tr>';
	     echo '<td>'.$release->getReleaseID().'</td>';
		 echo '<td>'.$release->getTitle().'</td>';
		 echo '<td>'.$release->getReleasedate().'</td>';
		 echo '<td>'.$release->getUrlOfOneDStore().'</td>';
		 echo '<td>'.$release->getUrlOfGooglePlay().'</td>';
		 echo '<td>'.$release->getUrlOfAmazon().'</td>';
		 echo '<td>'.$release->getUrlOfITunes().'</td>';
	     echo '</tr>';
		 
     }	
	 echo '</tbody>'; 	
	 echo '</table>';
	 echo '</div>'; 
 }
 
  if(isset($_POST["Refreash"])){	 
	  $visiblity="hidden";
  }
  
?>


</section>
</body>
</html>