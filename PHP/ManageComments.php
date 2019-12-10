<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage News</title>   
<link rel="stylesheet" href="../CSS/FormatManageComments.css">
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
  <li><a href="HomePageAdminPanel.php">Members</a></li>
  <li><a href="ManageReleaseAlbums.php">Release Albums</a></li>
  <li><a href="ManagePhotoAlbums.php">Photo Albums</a></li>
  <li><a href="ManageReleaseVideos.php">Videos</a></li> 
  <li><a href="ManageEvents.php">Events</a></li>
  <li><a href="ManageNews.php">News</a></li>
  <li class="active"><a href="#">Comments</a></li>
  <li><a href="ManageOneDMembers.php">One D Members</a></li>
  <li><a href="ManageProducts.php">Products</a></li>
</ul>
</div>
<?php
    require_once('Classes/Comment.php'); 
	
    $comment_id="";
	$comment_description="";
    $comment_date="";
    $news_id="";
    $user_name="";
 
   if(isset($_POST["btn_edit"])){
	   $commentId=$_POST["btn_edit"];
	   $c=new Comment();
	   $c=$c->getCommentAccordingToCommentId($commentId);
	   $comment_id=$c->getCommentId();
	   $comment_description=$c->getCommentDescription();
	   $comment_date=$c->getCommentDate();
	   $news_id=$c->getNewsId();
	   $user_name=$c->getUserName();	   	   
   }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">   
       <label for="comment_id">Comment ID:</label><br>
       <input type="text" name="comment_id" id="comment_id" class="input" readonly value="<?php if(isset($_POST["btn_edit"])) echo $comment_id;?>"><br><br>
       <label for="comment_description">Comment Description:</label><br>
       <textarea name="comment_description" rows="10" cols="55" id="lyrixText"><?php if(isset($_POST["btn_edit"])) echo $comment_description;?></textarea>
       <label for="comment_date">Comment Date:</label><br>
       <input type="text" name="comment_date" id="comment_date" class="input" readonly value="<?php if(isset($_POST["btn_edit"])) echo $comment_date;?>"><br><br>      
       <label for="news_id">News ID:</label><br>
       <input type="text" name="news_id_date" id="news_id" class="input" readonly value="<?php if(isset($_POST["btn_edit"])) echo $news_id;?>"><br><br> 
       <label for="user_name">User name:</label><br>
       <input type="text" name="user_name" id="user_name" class="input" readonly value="<?php if(isset($_POST["btn_edit"])) echo $user_name;?>"><br><br>                  
           
       <div id="buttons">
         
         <button type="submit" name="del">Delete</button>
         <button type="submit" name="update">Update</button> 
         <button type="submit" name="viewAll">View All</button>        
         <button type="submit" name="Refreash">Refreash</button>
       </div>
     </form>   
</div>
  


<?php
    require_once('Classes/AvoidErrors.php'); 
	require_once('Classes/Comment.php');       
   
   
   function loadData(){
	   $comment=new Comment();
	   $commentArray=$comment->getAllTheComments();
	   
	 echo '<div id="table_box">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>Comment ID</th>';
     echo '<th>Comment Description</th>';     
	 echo '<th>Comment Date</th>';	     
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($commentArray as $com){
		 $comment=$com;
		 		 
		 echo '<tr>';	     
		 echo '<td>'.$comment->getCommentId().'</td>';
		 echo '<td>'.$comment->getCommentDescription().'</td>';		 
		 echo '<td>'.$comment->getCommentDate().'</td>';
		 
		 echo '<td><form method="post"><button type="submit" value="'.$comment->getCommentId().'" name="btn_delete">Delete</button></td>';
		 echo '<td><button type="submit" name="btn_edit" value="'.$comment->getCommentId().'">Edit</button></td>';
		 echo '</form>';	 
	     echo '</tr>';
		 
     }	
	 echo '</tbody>'; 	
	 echo '</table>';
	 echo '</div>';
   }
   
   if(isset($_POST["btn_edit"])){
	   loadData();
	}
    
   //to avoid object incomplete error
   
	  $err=new Errors();
	  $err->fixObject($_SESSION["admin_details"]); 
   
   if(isset($_GET["link"])){
	   unset($_SESSION["admin_details"]);
	   header("Location:LoginFormAdmin.php");
   }
   
   if(isset($_POST["btn_delete"])){	
     
	   $commentID=$_POST["btn_delete"];
	   $s=new Comment();
	   $result=$s->deleteComment($commentID);	
	   loadData();   	    
	         
   }
   
   if(isset($_POST["viewAll"])){
	   loadData();
   } 
   
   
   
   if(isset($_POST["update"])){
	   $c2=new Comment();
	   $c2->setCommentDescription($_POST["comment_description"]);
	   $res=$c2->updateComment($_POST["comment_id"]);
	   if($res==true){				   
		  echo '<script>alert("Updated Succefully.")</script>';											   
	   }else{
		  echo '<script>alert("Sorry,Error Occurred.")</script>';
	   }
	   loadData();
   }
   
          
  if(isset($_POST["del"])){
	  if(empty($_POST["comment_id"])){
		  echo '<script>alert("Comment ID field is empty")</script>';
	  }else{
		  $s=new Comment();
		  $result=$s->deleteComment($_POST["comment_id"]);
		  if($result==true){
			  echo '<script>alert("Deleted!!!")</script>';
	      }else{
			  echo '<script>alert("Not Deleted!!!")</script>';
		  }
	  }
	  loadData();
  }
  
 
  if(isset($_POST["Refreash"])){	 
	  loadData();
  }
  
  
  
?>


</section>
</body>
</html>