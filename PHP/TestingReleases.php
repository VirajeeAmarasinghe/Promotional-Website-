<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Releases</title>
<link rel="stylesheet" href="../CSS/FormatReleases.css"></head>
</head>

<body>


<div id="top_stripe">
     <div id="search_box_form_div">
        <form method="post" name="search_box_form" id="search_box_form">
          <!--style="border:none->"to remove the border/outline around the text box--> 
          <input type="text" name="search_box" id="search_box">        
        </form>
      </div> 
      <div id="registration_nav">
        <ul>
          <li><a href="RegistrationForm.php">REGISTER</a></li>
          <li><a href="LoginForm.php">LOGIN</a></li>
        </ul>
      </div>
    </div>

<div id="second_stripe">
  <h1 id="singer_fname">ONE</h1>
  <h1 id="singer_lname">DIRECTION</h1>
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
         <li><a href="#">NEWS</a></li>
         <li><a href="http://www.onedirectionstore.com/">STORE</a></li>
         <li><a href="#">CONTACT</a></li>
      </ul>
   </div>
 </nav>
 <div id="main_wrapper">
  <?php
    session_start();
  
	require_once('config/config.php');
	require_once('Classes/ReleaseAlbum.php');
	
	define("PAGE_SIZE",2);
	
	$release=new ReleaseAlbum();
	
	$result=$release->GetReleases();
	
	$_SESSION['countReleases']=0;
	$count=0;
	
	foreach($result as $item){
		$count++;
	}
	
	$_SESSION['countReleases']=$count;
	
	if(!isset($_SESSION['start'])&&$_SESSION['countReleases']>0){
		$_SESSION['start']=1;
    }
	
	$start=1;
	if(isset($_POST['btn_action'])){
		$start=$_POST['btn_action'];		
    }	
	
	
	if(isset($_SESSION['start'])&&$_SESSION['countReleases']>0&&$start<=$_SESSION['countReleases']){
		$_end=$start+PAGE_SIZE-1;
		
		for($i=$start;$i<=$_end;$i++){
			$result=$release->GetReleasesAccordingToId($i);
			foreach($result as $albumRelease){
				  $release=$albumRelease;
				  $releaseID=$i;
				  $result2=$release->GetReleasesBannerImages($i);	
				  $release2=new ReleaseAlbum();
				  $imageSource="";
				  foreach($result2 as $image){
					  $release2=$image;
					  $imageSource="../Images/Releases Banner Images/".$release2->getBannerImage();
					  break;
				  }	
			    
				  echo '<div class="album">';		
				  echo '<img src="'.$imageSource.'" width="100%">';
				  echo '<div class="text">';		
				  echo '<h1 id="title">'.$release->getTitle().'</h1>';
				  echo '<p id="a" class="release_date">RELEASE DATE</p>';
				  echo '<p id="b" class="release_date">'.date( "d/m/Y",strtotime($release->getReleasedate())).'</p><br>';
				  echo '<h1 id="c"><a href="MadeInTheAM.php">FIND OUT MORE</a></h1>';
				  echo '</div>';
				  echo '</div>';	
		
           }
	    }
    }
	
	if($start>1){		
		$_SESSION['start']=$start-PAGE_SIZE;		
		echo '<a href="TestingReleases.php"><form method="post"><button name="btn_action" type="submit" value="'.$_SESSION['start'].'">Previous Page</button></form></a>';
	}
	if($start<$_SESSION['countReleases']){
		$_SESSION['start']=$start+PAGE_SIZE;
	echo '<a href="TestingReleases.php"><form method="post"><button name="btn_action" type="submit" value="'.$_SESSION['start'].'">Next Page</button></form></a>';
	}
	
  ?>    
      
      
  <div id="forth_stripe"> 
    <a href="Releases.php">
      <img id="top_to_page_img" src="../Images/Arrows-Up-Circular-icon.png" alt= "top_to_page" height="40px" width="40px">     
    </a>
    <h3 id="top">Top To Page</h3>    
</div>
    
 <nav class="sub">
  <div id="Nav_sub">
      <ul>
         <li><a href="#" class="highlight"><img src="../Images/facebook.jpg" alt="Facebook"></a></li> 
         <li><a href="#" class="highlight"><img src="../Images/Twitter.jpg" alt="Twitter"></a></li>
         <li><a href="#" class="highlight"><img src="../Images/p.jpg" alt="p"></a></li> 
         <li><a href="#" class="highlight"><img src="../Images/c.jpg" alt="c"></a></li>
         <li><a href="#" class="highlight"><img src="../Images/o.jpg" alt="o"></a></li> 
         <li><a href="#" class="highlight"><img src="../Images/uTube.jpg" alt="YouTube"></a></li>
         <li><a href="#" class="highlight"><img src="../Images/Cam.jpg" alt="cam"></a></li>
         <li><a href="#" class="highlight"><img src="../Images/googlePlus.jpg" alt="google_plus"></a></li>
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