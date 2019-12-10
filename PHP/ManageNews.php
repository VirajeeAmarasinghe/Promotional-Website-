<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage News</title>   
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
  <li><a href="#">News</a></li>
  <li><a href="ManageComments.php">Comments</a></li>
  <li><a href="ManageOneDMembers.php">One D Members</a></li>
  <li><a href="ManageProducts.php">Products</a></li>
</ul>
</div>
<?php
    
    require_once('Classes/News.php');
	
	
    $s=new News();
    $news_id="";
	$title="";
	$news_date="";
	$description="";
    
	$visi="disap";
	
	$source="../Images/News/";
	$vis="disVis";
	
	
	if(isset($_POST["search"])){
		if(isset($_POST["news_id"])){			
		    $s=$s->getNewsDetailsAccordingToId($_POST["news_id"]);
			$news_id=$s->getNewsId();
			$title=$s->getTitle();
			$news_date=$s->getNewsDate();
			$description=$s->getDescription();
						
			$vis="vis";
		    $comboVis="disVisCombo";
			
			
			$ImagesArray=$s->getImagesAccordingToId($news_id);
			foreach($ImagesArray as $Image){
				$source="../Images/News/".$Image;				
				echo '<img src="'.$source.'" class="song_images" width="300" height="300" alt="'.$Image.'">';
		    }			
	    }else{
			echo '<script>alert("Enter News ID")</script>';
	    }		
    }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">   
       <label for="news_id">News ID:</label><br>
       <input type="number" name="news_id" id="news_id" class="input" value="<?php if(isset($_POST["Refreash"])){ echo $s->getMaxID();}else if(isset($_POST["news_id"])){ echo $_POST["news_id"];}else{echo $s->getMaxID();}?>"><br><br>
       <label for="title">Title:</label><br>
       <input type="text" name="title" id="title" placeholder="Title" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $title;}else if(isset($_POST["title"])) echo $_POST["title"];?>"><br><br>
       <label for="news_date">News Date:</label><br>
       <input type="date" name="news_date" id="news_date" class="input" placeholder="mm/dd/yyyy" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $news_date;}else if(isset($_POST["news_date"])) echo $_POST["news_date"];?>"><br><br>             
           
           <br><br><label for="description">Description:</label><br>
           <textarea name="description" rows="10" cols="55" id="lyrixText" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $description;}else if(isset($_POST["description"])) echo $_POST["description"];?>"></textarea>
           <ul id="banner_buttons">
         <li>
           <label for="banner_image">Upload Image:</label><br><br>
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
     
	   $newsID=$_POST["btn_delete"];
	   $s=new News();
	   $result=$s->deleteNews($newsID);	    
	         
   } 
   
   if(isset($_POST["add"])){
	   if(validation()==true){
		   if(isset($_FILES["banner_image"])){	   
				
				$uploadOk2=true;
				$banner_names=array();
				
				
			     //upload image to the folder    //change photo name
				 for($i=0;$i<count($_FILES['banner_image']['name']);$i++){
			          $ext=pathinfo($_FILES['banner_image']['name'][$i],PATHINFO_EXTENSION);
			          if(move_uploaded_file($_FILES['banner_image']['tmp_name'][$i],'../Images/News/'.$_POST["news_id"].'+'.$_POST["title"].'+'.$i.'.'.$ext)){ 
				         $banner_names[]=$_POST["news_id"].'+'.$_POST["title"].'+'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading image failed.\nData not Saved in the DB.")</script>';
						   $uploadOk2=false;
					   }
				 
				 }
				 
				 $result4=false;
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $s=new News();
					   $s->setTitle($_POST["title"]);
					   $s->setNewsDate($_POST["news_date"]);
					   $s->setDescription($_POST["description"]);
					   
					   $result1=$s->addNewEvent();
					   if($result1==true){
						   for($i=0;$i<count($banner_names);$i++){
							   $s->setNewId($_POST["news_id"]);							   
							   $s->setImage($banner_names[$i]);
							   $res=$s->addNewEventImages();
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
			          if(move_uploaded_file($_FILES['banner_image']['tmp_name'][$i],'../Images/News/'.$_POST["news_id"].'+'.$_POST["title"].'+'.$i.'.'.$ext)){ 
				         $banner_names[]=$_POST["news_id"].'+'.$_POST["title"].'+'.$i.'.'.$ext;				 		 
		               }else{
						   echo '<script>alert("Uploading image failed.\nData not Saved in the DB.")</script>';
						   $uploadOk2=false;
					   }
				 
				 }
				 
				 $result4=false;
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $s=new News();
					   $s->setTitle($_POST["title"]);
					   $s->setNewsDate($_POST["news_date"]);
					   $s->setDescription($_POST["description"]);
					   
					   $result1=$s->updateNewsDetails($_POST["news_id"]);
					   if($result1==true){
						   $s->deleteNewsImages($_POST["news_id"]);
						   for($i=0;$i<count($banner_names);$i++){
							   $s->setNewId($_POST["news_id"]);							   
							   $s->setImage($banner_names[$i]);
							   $res=$s->addNewEventImages();
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
	   if(empty($_POST["news_id"])){
		   echo '<script>alert("News ID field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["title"])){
		   echo '<script>alert("Title field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["news_date"])){
		   echo '<script>alert("News date field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["description"])){
		   echo '<script>alert("Description field is empty")</script>';
		   $result=false;
	   }
	   return $result;
   } 
       
  if(isset($_POST["del"])){
	  if(empty($_POST["news_id"])){
		  echo '<script>alert("News ID field is empty")</script>';
	  }else{
		  $s=new News();
		  $result=$s->deleteNews($_POST["news_id"]);
		  if($result==true){
			  echo '<script>alert("Deleted!!!")</script>';
	      }else{
			  echo '<script>alert("Not Deleted!!!")</script>';
		  }
	  }
  }
  $visiblity="visible";
 if(isset($_POST["view_all"])||isset($_POST["btn_delete"])){
	 $release=new News();
	 $releaseArray2=$release->getAllTheNews2();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>News ID</th>';
     echo '<th>Title</th>';     
	 echo '<th>News Date</th>';
	 echo '<th>Description</th>';      
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 		 
		 echo '<tr>';	     
		 echo '<td>'.$release->getNewsId().'</td>';
		 echo '<td>'.$release->getTitle().'</td>';		 
		 echo '<td>'.$release->getNewsDate().'</td>';
		 echo '<td>'.$release->getDescription().'</td>';
		 echo '<td><form method="post"><button type="submit" value="'.$release->getNewsId().'" name="btn_delete">Delete</button></form></td>';	 
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