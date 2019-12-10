<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Events</title>   
<link rel="stylesheet" href="../CSS/FormatManageEvents.css">
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
  <li><a href="#">Events</a></li>
  <li><a href="ManageNews.php">News</a></li>
  <li><a href="ManageComments.php">Comments</a></li>
  <li><a href="ManageOneDMembers.php">One D Members</a></li>
  <li><a href="ManageProducts.php">Products</a></li>
</ul>
</div>

<?php
    
    require_once('Classes/Event.php');
	
    $a=new Event();
	
	$eventID="";
	$eventDate="";
	$venue="";
	$location="";

    
	$visi="disap";
	
	
	$vis="disVis";
	
	
	if(isset($_POST["search"])){
		if(isset($_POST["event_id"])){
			$eventID=$_POST["event_id"];			
		    $a=$a->GetEventAccordingToId($eventID);			
			$eventID=$a->getEventId();
			$eventDate=$a->getEventDate();
			$venue=$a->getVenue();
			$location=$a->getLocation();
			$vis="vis";			
						
	    }else{
			echo '<script>alert("Enter Event ID")</script>';
	    }		
    }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">   
       <label for="event_id">Event ID:</label><br>
       <input type="number" name="event_id" id="event_id" class="input" value="<?php if(isset($_POST["Refreash"])){ echo $a->getMaxID();}else if(isset($_POST["event_id"])){ echo $_POST["event_id"];}else{echo $a->getMaxID();}?>"><br><br>
       <label for="event_date">Event Date:</label><br>
       <input type="date" name="event_date" id="event_date" placeholder="mm/dd/yyyy" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $eventDate;}else if(isset($_POST["event_date"])) echo $_POST["event_date"];?>"><br><br>         
           
       <label for="venue">Venue:</label><br>
       <input type="text" name="venue" id="venue" placeholder="Venue" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $venue;}else if(isset($_POST["venue"])) echo $_POST["venue"];?>"><br><br>   
       
       <label for="location">Location:</label><br>
       <input type="text" name="location" id="location" placeholder="Location" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $location;}else if(isset($_POST["location"])) echo $_POST["location"];?>"><br><br>       
                    
           
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
	require_once('Classes/Event.php');      
   
    
   //to avoid object incomplete error
   
	  $err=new Errors();
	  $err->fixObject($_SESSION["admin_details"]); 
   
   if(isset($_GET["link"])){
	   unset($_SESSION["admin_details"]);
	   header("Location:LoginFormAdmin.php");
   }
   
   if(isset($_POST["btn_delete"])){	
     
	   $eventID=$_POST["btn_delete"];
	   $a2=new Event();
	   $result=$a2->deleteEvent($eventID);		   
	         
   } 
   
   if(isset($_POST["add"])){
	   if(validation()==true){ 				 
				 
			   $a3=new Event();
			   $a3->setEventDate($_POST["event_date"]);	
			   $a3->setVenue($_POST["venue"]);
			   $a3->setLocation($_POST["location"]);				   
			   
			   $result1=$a3->addNewEvent();
			   if($result1==true){				   
				  echo '<script>alert("Saved Succefully.")</script>';											   
			   }else{
				   echo '<script>alert("Sorry,Error Occurred.")</script>';
			   }				   
		 }		   
   }
   
   if(isset($_POST["update"])){		 
		if(validation()==true){ 				 
				 
			   $a3=new Event();
			   $a3->setEventDate($_POST["event_date"]);	
			   $a3->setVenue($_POST["venue"]);
			   $a3->setLocation($_POST["location"]);				   
			   
			   $result1=$a3->updateNewsDetails($_POST["event_id"]);
			   if($result1==true){				   
				  echo '<script>alert("Updated Succefully.")</script>';											   
			   }else{
				   echo '<script>alert("Sorry,Error Occurred.")</script>';
			   }				   
		 }			 
   }
   
   function validation(){
	   $result=true;
	   if(empty($_POST["event_id"])){
		   echo '<script>alert("Event ID field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["event_date"])){
		   echo '<script>alert("Event Date field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["venue"])){
		   echo '<script>alert("Venue field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["location"])){
		   echo '<script>alert("Location field is empty")</script>';
		   $result=false;
	   }
	   return $result;
   } 
       
  if(isset($_POST["del"])){
	  if(empty($_POST["event_id"])){
		  echo '<script>alert("Album ID field is empty")</script>';
	  }else{
		  $a4=new Event();
		  $result=$a4->deleteEvent($_POST["event_id"]);
		  if($result==true){
			  echo '<script>alert("Deleted!!!")</script>';
	      }else{
			  echo '<script>alert("Not Deleted!!!")</script>';
		  }
	  }
  }
  $visiblity="visible";
 if(isset($_POST["view_all"])||isset($_POST["btn_delete"])){
	 $release=new Event();
	 $releaseArray2=$release->GetAllEvents();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>Event ID</th>';
     echo '<th>Event Date</th>'; 
	 echo '<th>Venue</th>';
     echo '<th>Location</th>';	 
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 		 
		 echo '<tr>';	     
		 echo '<td>'.$release->getEventId().'</td>';
		 echo '<td>'.$release->getEventDate().'</td>';
		 echo '<td>'.$release->getVenue().'</td>';
		 echo '<td>'.$release->getLocation().'</td>';	
		 	 
		 
		 echo '<td><form method="post"><button type="submit" value="'.$release->getEventId().'" name="btn_delete">Delete</button></form></td>';	 
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