<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Release Songs</title>   
<link rel="stylesheet" href="../CSS/FormatManageReleaseSongs.css">
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
  <li><a href="javascript:history.go(-1)" title="Return to the previous page">Go Back</a></li>
  <li><a href="ManageReleaseAlbums.php">Manage Releases</a></li>
  <li><a href="ManageReleasePhotos.php">Release Photos</a></li>
  <li><a href="ManageReleaseSongs.php" class="this_form">Release Songs</a></li>
  <li><a href="ManageReleaseVideos.php">Release Videos</a></li>
  <li><a href="ManageSubBannerImages.php">Release Sub-banner images</a></li> 
  </ul>
</div>
<?php
    
    require_once('Classes/Song.php');
	require_once('Classes/ReleaseAlbum.php');
	require_once('Classes/SongImage.php');

	
    $s=new Song();
	$song_id="";
    $song_name="";
    $itune_url="";
    $googleOlay_url="";
    $spotify_url="";
    $lyric="";
    $release_id="";

    
	$visi="disap";
	
	$source="../Images/Songs/";
	$vis="disVis";
	$comboVis="visCombo";
	
	if(isset($_POST["search"])){
		if(isset($_POST["song_id"])){			
		    $s=$s->getSongAccordingToSongID($_POST["song_id"]);
			$song_id=$_POST["song_id"];
			$song_name=$s->getSongName();
			$url_iTune=$s->getITuneUrl();
			$url_googlePlay=$s->getGooglePlayUrl();
			$url_spotify=$s->getSpotifyUrl();
			$lyric=$s->getLyric();
			$release_id=$s->getReleaseId();
			
			$vis="vis";
		    $comboVis="disVisCombo";
			
			$sImage=new SongImage();
			$songImagesArray=$sImage->getImageAccordingToId($song_id);
			foreach($songImagesArray as $songImage){
				$source="../Images/Songs/".$songImage;				
				echo '<img src="'.$source.'" class="song_images" width="300" height="300" alt="'.$songImage.'">';
		    }			
	    }else{
			echo '<script>alert("Enter Song ID")</script>';
	    }		
    }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">   
       <label for="song_id">Song ID:</label><br>
       <input type="number" name="song_id" id="song_id" class="input" value="<?php if(isset($_POST["Refreash"])){ echo $s->getMaxID();}else if(isset($_POST["song_id"])){ echo $_POST["song_id"];}else{echo $s->getMaxID();}?>"><br><br>
       <label for="song_name">Song Name:</label><br>
       <input type="text" name="song_name" id="title" placeholder="Song Name" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $song_name;}else if(isset($_POST["song_name"])) echo $_POST["song_name"];?>"><br><br>
       <label for="url_iTune">iTune URL:</label><br>
       <input type="text" name="url_iTune" id="url_iTune" class="input" placeholder="iTune URL" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $url_iTune;}else if(isset($_POST["url_iTune"])) echo $_POST["url_iTune"];?>"><br><br>
       <label for="url_googlePlay">URL Of Googleplay:</label><br>
       <input type="text" name="url_googlePlay" id="url_googlePlay" placeholder="Url Of GooglePlay" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $url_googlePlay;}else if(isset($_POST["url_googlePlay"])) echo $_POST["url_googlePlay"];?>"><br><br>
       <label for="url_spotify">URL Of Spotify:</label><br>
       <input type="text" name="url_spotify" id="url_spotify" placeholder="Url Of Spotify" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $url_spotify;}else if(isset($_POST["url_spotify"])) echo $_POST["url_spotify"];?>"><br><br>
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
           <br><br><label for="lyric">Lyric:</label><br>
           <textarea name="lyric" rows="10" cols="55" id="lyrixText"><?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $lyric;}else if(isset($_POST["lyric"])) echo $_POST["lyric"];?></textarea>
           <ul id="banner_buttons">
         <li>
           <label for="banner_image">Upload Banner Image:</label><br><br>
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
     
	   $songID=$_POST["btn_delete"];
	   $s=new Song();
	   $result=$s->deleteSong($songID);	
	   
	   //reload data
	   $visiblity="visible";
	   $release=new Song();
	 $releaseArray2=$release->GetSongs();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>Song ID</th>';
     echo '<th>Song Name</th>';     
	 echo '<th>Release ID</th>';     
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 		 
		 echo '<tr>';	     
		 echo '<td>'.$release->getSongId().'</td>';
		 echo '<td>'.$release->getSongName().'</td>';		 
		 echo '<td>'.$release->getReleaseId().'</td>';
		 echo '<td><form method="post"><button type="submit" value="'.$release->getSongId().'" name="btn_delete">Delete</button></form></td>';	 
	     echo '</tr>';
		 
     }	
	 echo '</tbody>'; 	
	 echo '</table>';
	 echo '</div>'; 
	         
   } 
   
   if(isset($_POST["add"])){
	   if(validation()==true){
		   if(isset($_FILES["banner_image"])){	   
				
				$uploadOk2=true;
				$banner_names=array();
				
				
			     //upload image to the folder    //change photo name
				 for($i=0;$i<count($_FILES['banner_image']['name']);$i++){
			          $ext=pathinfo($_FILES['banner_image']['name'][$i],PATHINFO_EXTENSION);
			          if(move_uploaded_file($_FILES['banner_image']['tmp_name'][$i],'../Images/Songs/'.$_POST["song_name"].'SongImage'.$i.'.'.$ext)){ 
				         $banner_names[]=$_POST["song_name"].'SongImage'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading-song image failed.\nData not Saved in the DB.")</script>';
						   $uploadOk2=false;
					   }
				 
				 }
				 
				 $result4=false;
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $s=new Song();
					   $s->setSongName($_POST["song_name"]);
					   $s->setItuneUrl($_POST["url_iTune"]);
					   $s->setGooglePlayUrl($_POST["url_googlePlay"]);
					   $s->setSpotifyUrl($_POST["url_spotify"]);
					   $s->setReleaseId($_POST["rel_date"]);
					   $s->setLyric($_POST["lyric"]);
					   
					   $result1=$s->addNewSong();
					   if($result1==true){
						   for($i=0;$i<count($banner_names);$i++){
							   $songImage=new SongImage();
							   $songImage->setSongId($_POST["song_id"]);
							   $songImage->setSongImage($banner_names[$i]);
							   $res=$songImage->addNewSongImage();
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
			          if(move_uploaded_file($_FILES['banner_image']['tmp_name'][$i],'../Images/Songs/'.$_POST["song_name"].'SongImage'.$i.'.'.$ext)){ 
				         $banner_names[]=$_POST["song_name"].'SongImage'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading-song image failed.\nData not Saved in the DB.")</script>';
						   $uploadOk2=false;
					   }
				 
				 }
				 
				 $result4=false;
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $s=new Song();
					   $s->setSongName($_POST["song_name"]);
					   $s->setItuneUrl($_POST["url_iTune"]);
					   $s->setGooglePlayUrl($_POST["url_googlePlay"]);
					   $s->setSpotifyUrl($_POST["url_spotify"]);
					   $s->setReleaseId($_POST["rel_date"]);
					   $s->setLyric($_POST["lyric"]);
					   
					   $result1=$s->updateSongDetails($_POST["song_id"]);
					   if($result1==true){
						   $songImage=new SongImage();
						   $songImage->deleteSongImages($_POST["song_id"]);
						   for($i=0;$i<count($banner_names);$i++){
							   $songImage=new SongImage();
							   $songImage->setSongId($_POST["song_id"]);
							   $songImage->setSongImage($banner_names[$i]);
							   $res=$songImage->addNewSongImage();
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
	   if(empty($_POST["song_id"])){
		   echo '<script>alert("Song ID field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["song_name"])){
		   echo '<script>alert("Song Name field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_iTune"])){
		   echo '<script>alert("iTune field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_googlePlay"])){
		   echo '<script>alert("URL of googlePlay field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["url_spotify"])){
		   echo '<script>alert("URL of spotify field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["lyric"])){
		   echo '<script>alert("Lyric field is empty")</script>';
		   $result=false;
	   }
	   return $result;
   } 
       
  if(isset($_POST["del"])){
	  if(empty($_POST["song_id"])){
		  echo '<script>alert("Song ID field is empty")</script>';
	  }else{
		  $s=new Song();
		  $result=$s->deleteSong($_POST["song_id"]);
		  if($result==true){
			  echo '<script>alert("Deleted!!!")</script>';
	      }else{
			  echo '<script>alert("Not Deleted!!!")</script>';
		  }
	  }
  }
  $visiblity="visible";
 if(isset($_POST["view_all"])){
	 $release=new Song();
	 $releaseArray2=$release->GetSongs();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>Song ID</th>';
     echo '<th>Song Name</th>';     
	 echo '<th>Release ID</th>';     
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 		 
		 echo '<tr>';	     
		 echo '<td>'.$release->getSongId().'</td>';
		 echo '<td>'.$release->getSongName().'</td>';		 
		 echo '<td>'.$release->getReleaseId().'</td>';
		 echo '<td><form method="post"><button type="submit" value="'.$release->getSongId().'" name="btn_delete">Delete</button></form></td>';	 
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