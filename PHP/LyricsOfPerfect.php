<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      <?php	
		session_start();		
		
		require_once('Classes/Song.php');
		if(isset($_SESSION["song"])){
		   $song=new Song();
		   $songName=$song->getSongNameAccordingToId($_SESSION["song"]);		   
		   echo $songName.' Lyric';		  
	   }	   
     ?>
    </title>
    <link rel="stylesheet" href="../CSS/FormatLyricsOfPerfect.css">    
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
          <?php if(isset($_SESSION["user_details"])){
		             echo '<li><a href="?link=logoutLink">LOG OUT</a></li>';
			     }else if(!isset($_SESSION["user_details"])){
					 echo '<li><a href="LoginForm.php">LOGIN</a></li>';
				 }
		  ?>          
        </ul>
      </div>

<?php if(isset($_GET["link"])){
	        unset($_SESSION["user_details"]);
	        header("Location:HomePage.php");
       }
   ?>
    </div>
    
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
           <li><a href="Releases.php" class="this_form">RELEASES</a></li>
           <li><a href="Events.php">EVENTS</a></li>
           <li><a href="Photos.php">PHOTOS</a></li>
           <li><a href="Videos.php">VIDEOS</a></li>
           <li><a href="News.php">NEWS</a></li>
           <li><a href="StoreOneDirection.php">STORE</a></li>
           <li><a href="Contact.php">CONTACT</a></li>
        </ul>
        </div>
    </nav>    
      
    
    <?php
       require_once('Classes/SubBannerImage.php');
	   require_once('Classes/Song.php');
	   require_once('Classes/SongImage.php');	  
	   
	   if(isset($_SESSION["album"])){
			
		   $s1=new SubBannerImage();
		   $banerImageArray=$s1->getSubBannerImage($_SESSION["album"]);
		   
		   foreach($banerImageArray as $subBannerImageObject){
			   $s1=$subBannerImageObject;
			   $imageSource="../Images/Sub Banner Images/".$s1->getSubBannerImageName();
			   echo '<div id="top_banner">';
               echo '<img src="'.$imageSource.'" width="100%" height="auto" class="top_banner_img">';
			   
			   $titleImageSource="../Images/Sub Banner Images/Title/".$s1->getSubBannerImageTitle();
	           
		       echo '<h2><img src="'.$titleImageSource.'"></h2>';
			   echo '</div>';
		   }
	   }
	   if(isset($_SESSION["song"])){
		   $s=new Song();
	       $songLyric=$s->getSongLyric($_SESSION["song"]);
	   
		   echo '<div class="lyric_section">';
		   $name=$s->getSongNameAccordingToId($_SESSION["song"]);
		   echo '<h2>'.$name.'</h2>';
		   echo '<p>';
		   echo '<pre>'.$songLyric.'</pre>';                
		   echo '<p>';
		   echo '</div>';
	   }
	   
	   
	   
	?>     
    
    
    
   <div id="forth_stripe"> 
      <a href="LyricsOfPerfect.php">
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