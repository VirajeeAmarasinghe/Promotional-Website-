<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      <?php
	      require_once('Classes/AlbumPhoto.php');
          if(isset($_GET['photoId'])){
			  $a=new AlbumPhoto();
			  $name=$a->getPhotoAlbumName($_GET['photoId']);
			  echo $name.' Photos';
		  }
	  ?>
    </title>
    <link rel="stylesheet" href="../CSS/FormatBBCMusicAwards.css">
    <link rel="stylesheet" href="../CSS/hover.css" media="all">
  </head>
  
  <body>
  
    <div id="top_stripe">
     <div class="back">
      <p class="goToBack"><a href="javascript:history.go(-1)" title="Return to the previous page" class="goBack">&laquo; GO BACK</a></p>';
     </div>
     <div id="search_box_form_div">
        <form method="post" name="search_box_form" id="search_box_form">
          <!--style="border:none->"to remove the border/outline around the text box--> 
          <input type="text" name="search_box" id="search_box">        
        </form>
      </div> 
      <div id="registration_nav">
        <ul>
          <li><a href="RegistrationForm.php">REGISTER</a></li>
          <?php session_start();if(isset($_SESSION["user_details"])){
		             echo '<li><a href="?link=logoutLink">LOG OUT</a></li>';
			     }else if(!isset($_SESSION["user_details"])){
					 echo '<li><a href="LoginForm.php">LOGIN</a></li>';
				 }
		  ?>          
        </ul>
      </div>
    </div>
    
    <?php if(isset($_GET["link"])){
	        unset($_SESSION["user_details"]);
	        header("Location:HomePage.php");
       }
   ?>
    
    <div id="second_stripe">
      <a href="HomePage.php">
        <h1 id="singer_fname">ONE</h1>
        <h1 id="singer_lname">DIRECTION</h1>
      </a>
    </div>
    
    <nav class="main">
    <div id="Nav">
        <ul>
           <li><a href="HomePage.php">HOME</a></li>
           <li><a href="One Direction.php">ONE DIRECTION</a></li>
           <li><a href="Releases.php">RELEASES</a></li>
           <li><a href="Events.php">EVENTS</a></li>
           <li><a href="Photos.php" class="this_form">PHOTOS</a></li>
           <li><a href="Videos.php">VIDEOS</a></li>
           <li><a href="News.php">NEWS</a></li>
           <li><a href="StoreOneDirection.php">STORE</a></li>
           <li><a href="Contact.php">CONTACT</a></li>
        </ul>
        </div>
    </nav>
    
    <?php
		
      if(isset($_GET['photoId'])){
		  $album=new AlbumPhoto();
		  
		  $photo_per_page=9;
	      $totalNumberOfRecords=(int)($a->getTotalNumberOfPhotos($_GET['photoId']));
	
	      //get total number of pages
	 
	      $numOfPages=ceil($totalNumberOfRecords/$photo_per_page);
	 
	      $page=0;
	      $offset=0;
	 
	      if(isset($_GET['page'])) {
	           $page =((int)$_GET['page']) + 1;
	           $offset = $photo_per_page * $page ;
	      }else {
	           $page = 0;
	           $offset = 0;
	      }
		  
		  $left_rec = $totalNumberOfRecords-($page * $photo_per_page);

          $photoArray=$album->getAllThePhotosAccordingTolAlbum($offset,$photo_per_page,$_GET['photoId']);
		  
		  $sizeOfPhotoArray=sizeof($photoArray);
		  
		  for($i=0;$i<$sizeOfPhotoArray;$i++){			  
			  $source="../Images/Photo Albums/".$photoArray[$i]; 			
			  echo '<div id="photo" class="photo">';
			  echo '<a href="#" class="hvr-grow"><img src="'.$source.'"> </a>';
			  echo '</div>';
		  }
		  
		  $_PHP_SELF="BBCMusicAwards.php";
		  $realPageNo=$page+1;		  
		  
		  $photoId=$_GET['photoId'];
		  if( $page > 0 && $realPageNo<$numOfPages) {
			  $last = $page - 2;
			  echo "<a href = \"$_PHP_SELF?page=".$last."&amp;photoId=".$photoId."\" class=\"links\">PREVIOUS</a>";
			  echo "<a href = \"$_PHP_SELF?page=".$page."&amp;photoId=".$photoId."\" class=\"links\">NEXT</a>";
		  }else if( $page == 0 && $numOfPages!=1) {
			  echo "<a href = \"$_PHP_SELF?page=".$page."&amp;photoId=".$photoId."\" class=\"links\">NEXT</a>";
		  }else if( $left_rec<=$photo_per_page && $photo_per_page<$totalNumberOfRecords) {
			  $last = $page - 2;
			  echo "<a href = \"$_PHP_SELF?page=".$last."&amp;photoId=".$photoId."\" class=\"links\">PREVIOUS</a>";
		  }
	   }
	?>   
        
        
   <div id="forth_stripe"> 
      <a href="#">
       <img id="top_to_page_img" src="../Images/Arrows-Up-Circular-icon.png" alt= "top_to_page" height="40px" width="40px">     
       </a>
        <h3 id="top">Top To Page</h3>    
    </div>
    
      
    <nav class="sub">
    <div id="Nav_sub">
      <ul>
           <li><a href="https://web.facebook.com/onedirectionmusic?_rdr" class="highlight"><img src="../Images/facebook.jpg" alt="Facebook"></a></li> 
           <li><a href="https://twitter.com/onedirection" class="highlight"><img src="../Images/Twitter.jpg" alt="Twitter"></a></li>
           <li><a href="https://www.pinterest.com/1dofficial/" class="highlight"><img src="../Images/p.jpg" alt="p"></a></li> 
           <li><a href="https://soundcloud.com/onedirectionmusic" class="highlight"><img src="../Images/c.jpg" alt="c"></a></li>
           <li><a href="https://open.spotify.com/artist/4AK6F7OLvEQ5QYCBNiQWHq" class="highlight"><img src="../Images/o.jpg" alt="o"></a></li> 
           <li><a href="https://www.youtube.com/user/OneDirectionVEVO" class="highlight"><img src="../Images/uTube.jpg" alt="YouTube"></a></li>
           <li><a href="instagram.com/onedirection" class="highlight"><img src="../Images/Cam.jpg" alt="cam"></a></li>
           <li><a href="https://plus.google.com/+OneDirection/posts" class="highlight"><img src="../Images/googlePlus.jpg" alt="google_plus"></a></li>
        </ul>
        </div>
    </nav>
   
   <div id="footer">
      <div id="footer_para">
        <p>Copyright © 2015 One Direction. All Rights Reserved.</p>
      </div>
  </div>
   
  </body>
</html>