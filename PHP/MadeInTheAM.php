<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php
	
	session_start();
    
    require_once('Classes/ReleaseAlbum.php');
    if(isset($_SESSION["album"])){
	   $r=new ReleaseAlbum();
	   $r2=$r->GetReleasesAccordingToId($_SESSION["album"]);
	   foreach($r2 as $album){
		   $r=$album;
		   echo $r->getTitle();
	  }
   }
?>
</title>
    <link rel="stylesheet" href="../CSS/FormatMadeInTheAM.css">
    <link href="../CSS/hover.css" rel="stylesheet" media="all">        
  </head>
  
  <body>
    <div id="top_stripe">
     <div class="back">
      <?php $referer = $_SERVER['HTTP_REFERER'];
        if (!$referer == '') {
          echo '<p class="goToBack"><a href="' . $referer . '" title="Return to the previous page" class="goBack">&laquo; GO BACK</a></p>';
        } else {
           echo '<p class="goToBack"><a href="javascript:history.go(-1)" title="Return to the previous page" class="goBack">&laquo; GO BACK</a></p>';
        }
      ?>      
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
           <li><a href="Releases.php" class="home">RELEASES</a></li>
           <li><a href="Events.php">EVENTS</a></li>
           <li><a href="Photos.php">PHOTOS</a></li>
           <li><a href="Videos.php">VIDEOS</a></li>
           <li><a href="News.php">NEWS</a></li>
           <li><a href="StoreOneDirection.php">STORE</a></li>
           <li><a href="Contact.php">CONTACT</a></li>
        </ul>
        </div>
    </nav>
    
    </div>
    <?php	
	   require_once('Classes/SubBannerImage.php');
	   require_once('Classes/AlbumCoverPhoto.php');	   
	   
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
               echo '<div class="share">';
               echo '<a class="fbshare" href="'.$s1->getFbShareUrl().'">';
               echo '<img src="../Images/facebook2.png" alt="share in facebook" width="24px" height="24px">';               echo '</a>';        
               echo '<a class="tweetshare" href="'.$s1->getTwitShareUrl().'">';
               echo '<img src="../Images/twitter3.gif" alt="share in twitter" width="24px" height="24px">';
               echo '</a>';
               echo '<a class="gPlusShare" href="'.$s1->getGoogleShareUrl().'">';
               echo '<img src="../Images/icon_googleplus.png" alt="share in google+" width="24px" height="24px">';
               echo '</a>';      
               echo '</div>';
               echo '</div>';
		   }
   }  
    
    
  echo '<div class="panel_group">';
  echo '<div class="panel_group_menu">';
  echo '<ul>';
  echo '<li><a id="video_menu" href="MadeInTheAmVideo.php"><span id="underlined"><b class="hvr-pop">VIDEOS</b></span></a></li>';
  echo '<li><a id="photo_menu" href="MadeInTheAmPhoto.php"><span id="underlined"><b class="hvr-pop">PHOTOS</b></span></a></li>';
  echo '<li><a id="songs_menu" href="MadeInTheAmSong.php"><span><b class="hvr-pop">SONGS</b></span></a></li>';      
  echo '</ul>';
  echo '</div>';
  echo '<div class="panel_group_buy">';
  echo '<div class="panel_group_buy_header">';        
  echo '<div class="title">';
  $r=new ReleaseAlbum();
  $r2=$r->GetReleasesAccordingToId($_SESSION["album"]);
  foreach($r2 as $album){
    $r=$album;
    echo $r->getTitle();
  }            
  echo '</div>';
  echo '<div class="buy"><span id="underlined_word"><b>BUY</b></span></div>';                               
  echo '</div>';
  echo '<div class="MadeInTheAMCoverPhoto">';
  $a=new AlbumCoverPhoto();
  $photoArray=$a->GetPhotoAccordingToId($_SESSION["album"]);
  foreach($photoArray as $photo){
	  $a=$photo;
	  $source="../Images/Sub Banner Images/Album Cover Photos/".$a->getalbumCoverPhoto();
	  echo '<img src="'.$source.'" alt="'.$a->getalbumCoverPhoto().'" width="300">';
  }
  echo '</div>';
  echo '<div class="purchase_album">';
  echo '<div>';
  
  $r3=new ReleaseAlbum();
  $releaseAlbumArray=$r3->GetReleasesAccordingToId($_SESSION["album"]);
  $linkForOneDStore="";
  $linkForAmazon=""; 
  $linkForITunes="";
  $linkForGooglePlay="";
  foreach($releaseAlbumArray as $url){
	 $r3=$url;
	 $linkForOneDStore=$r3->getUrlOfOneDStore();
	 $linkForAmazon=$r3->getUrlOfAmazon();
	 $linkForITunes=$r3->getUrlOfITunes();
	 $linkForGooglePlay=$r3->getUrlOfGooglePlay();
  }
  
  echo '<div id="OneDStore" class="purchase"><a href="'.$linkForOneDStore.'">OFFICIAL 1D STORE</a></div>';
  echo '<div id="Amazon" class="purchase"><a href="'.$linkForAmazon.'">AMAZON</a></div>';
  echo '</div>';
  echo '<div class="second_row">';
  echo '<div id="ITunes" class="purchase"><a href="'.$linkForITunes.'">ITUNES</a></div>';
  echo '<div id="GooglePlay" class="purchase"><a href="'.$linkForGooglePlay.'">GOOGLE PLAY</a></div>';
  echo '</div></div></div></div>';
  ?>  
    <div id="forth_stripe"> 
      <a href="MadeInTheAM.php">
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