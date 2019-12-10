<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Videos</title>
    <link rel="stylesheet" href="../CSS/FormatVideo.css">
  </head>
  
  <body>     
  <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script> 
  <script>
  
  
  
  $(document).ready(function() {
            $('#player').hide(); // on document ready youtube player will be hiden.
            $('#btn').click(function() {  // as user click on overlay image.
                $('#player').show();    // player will be visible to user 
                $('#video').hide(); // and overlay image will be hidden.
            });
        });
      
    
  </script>
  
  
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
           <li><a href="Photos.php">PHOTOS</a></li>
           <li><a href="Videos.php" class="this_form">VIDEOS</a></li>
           <li><a href="#">NEWS</a></li>
           <li><a href="http://www.onedirectionstore.com/">STORE</a></li>
           <li><a href="#">CONTACT</a></li>
        </ul>
        </div>
    </nav>
    
    <?php
	   session_start();
       require_once('Classes/Video.php');
	   
	   if(isset($_POST['btn_play'])){
		   $_SESSION['url']=$_POST['btn_play'];
	   }
	   
	   $v=new Video();
	   $videoArray=$v->getAllTheVideos();
	   
	   foreach($videoArray as $video){
		   $v=$video;		   
		   echo '<div id="video" class="video">';
		   $source="../Images/Sub Banner Images/Video Images/".$v->getVideoImage();
		   echo '<img class="image_main" src="'.$source.'" alt="'.$v->getVideoImage().'" width="100%">';
		   echo '<p>'.$v->getVideoName().'</p>';
		   echo '<form method="post"><input type="image" src="Image/play-icon.png" id="btn" name="btn_play" value="'.$v->getUrl().'"></input></form>';
		   echo '</div>';
		   echo '<div id="player"><iframe src="//www.youtube.com/embed/Ho32Oh6b4jc?rel=0&showinfo=0&wmode=transparent&autoplay=0" width="auto" height="auto" frameborder="1" allowFullScreen></iframe></div>';
	   }
  
      ?>  
   <div id="forth_stripe"> 
      <a href="Videos.php">
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